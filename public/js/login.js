    // Tab switching logic
    const btnCustomer = document.getElementById('btn-customer');
    const btnAdmin = document.getElementById('btn-admin');
    const customerForm = document.getElementById('customer-form');
    const adminForm = document.getElementById('admin-form');
    const loginTitle = document.getElementById('login-title');
    const loginDesc = document.getElementById('login-desc');

    btnCustomer.addEventListener('click', function() {
        btnCustomer.classList.add('active');
        btnAdmin.classList.remove('active');
        customerForm.classList.add('active');
        adminForm.classList.remove('active');
        loginTitle.textContent = 'Login Customer';
        loginDesc.textContent = 'Akses untuk menitipkan kendaraan dan akan dijemput';
    });

    btnAdmin.addEventListener('click', function() {
        btnAdmin.classList.add('active');
        btnCustomer.classList.remove('active');
        adminForm.classList.add('active');
        customerForm.classList.remove('active');
        loginTitle.textContent = 'Login Admin';
        loginDesc.textContent = 'Akses untuk mengelola sistem AutoSafe';
    });