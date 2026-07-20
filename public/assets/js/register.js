document.addEventListener('DOMContentLoaded', function() {
    // Auto-format redeem code input: uppercase + tambah strip otomatis
    const redeemInput = document.querySelector('input[name="redeem_code"]');
    if (redeemInput) {
        redeemInput.addEventListener('input', function() {
            let val = this.value.replace(/[^A-Z0-9a-z]/gi, '').toUpperCase();
            if (val.length > 2) {
                val = 'BS-' + val.replace(/^BS/i, '').substring(0, 6);
            }
            this.value = val;
        });
    }
});
