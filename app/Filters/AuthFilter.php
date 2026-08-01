<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        // Cek secara real-time apakah akun user masih ada di database
        $db = \Config\Database::connect();
        $userExists = $db->table('users')->where('user_id', session()->get('id'))->get()->getRow();
        if (!$userExists) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Akun Anda telah dikeluarkan oleh administrator.');
        }

        if ($arguments && is_array($arguments)) {
            $role = session()->get('role');
            if (!in_array($role, $arguments)) {
                // Redirect ke dashboard sesuai role masing-masing
                if ($role === 'super_admin') {
                    return redirect()->to('/superadmin');
                } elseif ($role === 'admin') {
                    return redirect()->to('/admin');
                } else {
                    return redirect()->to('/user');
                }
            }
        }

        // Cek status suspend (kecuali admin dan super_admin)
        $currentRole = session()->get('role');
        if ($currentRole !== 'admin' && $currentRole !== 'super_admin' && session()->get('id_game')) {
            $uri = trim($request->getUri()->getPath(), '/');
            // Kecuali rute logout dan suspended itu sendiri
            if (!in_array($uri, ['logout', 'suspended'])) {
                // Cek database secara real-time untuk mendeteksi status suspend terbaru dari admin
                $db = \Config\Database::connect();
                $kreator = $db->table('kreator')->where('id_game', session()->get('id_game'))->get()->getRow();
                if ($kreator) {
                    session()->set('status', $kreator->status);
                    if ($kreator->status === 'suspended') {
                        return redirect()->to('/suspended');
                    }
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Logika tambahan jika diperlukan setelah request dijalankan
    }
}

