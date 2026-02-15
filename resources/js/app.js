import './bootstrap';
import './metronome';
import './video-player';

// SB Admin Pro JavaScript Functions
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });

    // Confirm deletions
    const deleteForms = document.querySelectorAll('form[data-confirm-delete]');
    deleteForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('¿Estás seguro de que deseas eliminar este elemento?')) {
                e.preventDefault();
            }
        });
    });

    // Initialize tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Initialize popovers
    if (typeof bootstrap !== 'undefined' && bootstrap.Popover) {
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    }
});

// Helper function for currency formatting
window.formatCurrency = function(amount) {
    return new Intl.NumberFormat('es-AR', {
        style: 'currency',
        currency: 'ARS',
        minimumFractionDigits: 2
    }).format(amount);
};

// Helper function for date formatting
window.formatDate = function(date) {
    return new Date(date).toLocaleDateString('es-AR', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    });
};

// Helper function for SweetAlert2 toasts
window.showToast = function(type, title, message, duration = 4000) {
    const configs = {
        success: {
            icon: 'success',
            iconColor: '#1e8081',
        },
        error: {
            icon: 'error',
            iconColor: '#e74a3b',
        },
        warning: {
            icon: 'warning',
            iconColor: '#f6c23e',
        },
        info: {
            icon: 'info',
            iconColor: '#36b9cc',
        }
    };
    
    const config = configs[type] || configs.info;
    
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: config.icon,
            title: title,
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: duration,
            timerProgressBar: true,
            iconColor: config.iconColor,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    }
};

// Helper function for confirmations
window.showConfirm = function(title, message, confirmText = 'Sí', cancelText = 'Cancelar') {
    if (typeof Swal !== 'undefined') {
        return Swal.fire({
            icon: 'question',
            title: title,
            text: message,
            showCancelButton: true,
            confirmButtonColor: '#1e8081',
            cancelButtonColor: '#858796',
            confirmButtonText: confirmText,
            cancelButtonText: cancelText
        });
    }
    return Promise.resolve({ isConfirmed: confirm(message) });
};

// Helper function for loading spinner
window.showLoading = function(message = 'Cargando...') {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: message,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }
};

// Helper function to hide loading
window.hideLoading = function() {
    if (typeof Swal !== 'undefined') {
        Swal.close();
    }
};
