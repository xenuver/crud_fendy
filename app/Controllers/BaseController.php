<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];
        $this->helpers = array_merge($this->helpers, ['system', 'foto']);

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }

    /**
     * Helper untu mengarahkan user ke dashboard sesuai role
     */
    protected function redirectDashboard()
    {
        if (session()->get('role') == 'admin') {
            return redirect()->to('/admin');
        } else {
            return redirect()->to('/user');
        }
    }

    /**
     * Helper untuk mengecek kepemilikan data (Ownership)
     */
    protected function checkOwnership($record, $userIdField = 'user_id')
    {
        if (!$record) return false;
        
        // Admin selalu punya akses
        if (session()->get('role') == 'admin') return true;
        
        // User hanya punya akses jika user_id cocok
        return session()->get('id') == $record[$userIdField];
    }

    /**
     * Helper untuk mengecek apakah periode input laporan sedang dibuka
     * Window: Senin 00:00 - Rabu 15:00
     */
    protected function isSubmissionOpen()
    {
        return is_submission_open();
    }

    /**
     * Helper untuk merender view dengan template standar.
     */
    protected function renderView(string $view, array $data = [])
    {
        return view('templates/v_header', $data)
             . view('templates/v_sidebar')
             . view('templates/v_topbar')
             . view($view, $data)
             . view('templates/v_footer');
    }
}
