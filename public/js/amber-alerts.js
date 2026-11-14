/**
 * Amber's Roots - Premium Luxury Custom Alerts, Modals & Toast System
 * Fully replaces native browser alert() and confirm() dialogs.
 */

(function (window, document) {
    'use strict';

    // -------------------------------------------------------------
    // 1. Toast Notification Engine
    // -------------------------------------------------------------
    let toastContainer = null;

    function getToastContainer() {
        if (!toastContainer || !document.body.contains(toastContainer)) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'amber-toast-container';
            document.body.appendChild(toastContainer);
        }
        return toastContainer;
    }

    const AmberToast = {
        show: function (message, type = 'success', duration = 3500, title = '') {
            const container = getToastContainer();
            const toast = document.createElement('div');
            toast.className = `amber-toast toast-${type}`;

            let iconHtml = '<i class="fa-solid fa-circle-check"></i>';
            if (type === 'error') iconHtml = '<i class="fa-solid fa-triangle-exclamation"></i>';
            else if (type === 'warning') iconHtml = '<i class="fa-solid fa-circle-exclamation"></i>';
            else if (type === 'info') iconHtml = '<i class="fa-solid fa-circle-info"></i>';

            const titleHtml = title ? `<strong>${title}</strong>` : '';

            toast.innerHTML = `
                <div class="amber-toast-icon">${iconHtml}</div>
                <div class="amber-toast-body">${titleHtml}<span>${message}</span></div>
                <button type="button" class="amber-toast-close" aria-label="Close">&times;</button>
                <div class="amber-toast-progress" style="animation-duration: ${duration}ms;"></div>
            `;

            container.appendChild(toast);

            // Force reflow for CSS transition
            requestAnimationFrame(() => {
                toast.classList.add('is-visible');
            });

            const closeToast = () => {
                toast.classList.remove('is-visible');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 350);
            };

            const closeBtn = toast.querySelector('.amber-toast-close');
            if (closeBtn) closeBtn.addEventListener('click', closeToast);

            const timer = setTimeout(closeToast, duration);
            toast.addEventListener('mouseenter', () => clearTimeout(timer));

            return toast;
        },

        success: function (msg, title = 'Success') {
            return this.show(msg, 'success', 3500, title);
        },
        error: function (msg, title = 'Attention') {
            return this.show(msg, 'error', 4500, title);
        },
        warning: function (msg, title = 'Warning') {
            return this.show(msg, 'warning', 4000, title);
        },
        info: function (msg, title = 'Info') {
            return this.show(msg, 'info', 3500, title);
        }
    };

    // -------------------------------------------------------------
    // 2. Custom Modal Alert & Confirm Engine
    // -------------------------------------------------------------
    let alertOverlay = null;

    function buildAlertDOM() {
        if (alertOverlay && document.body.contains(alertOverlay)) {
            return alertOverlay;
        }

        alertOverlay = document.createElement('div');
        alertOverlay.className = 'amber-alert-overlay';
        alertOverlay.innerHTML = `
            <div class="amber-alert-card" role="dialog" aria-modal="true">
                <div class="amber-alert-icon-wrap" id="amberAlertIconWrap">
                    <i id="amberAlertIcon" class="fa-solid fa-circle-check"></i>
                </div>
                <h3 class="amber-alert-title" id="amberAlertTitle">Alert</h3>
                <div class="amber-alert-text" id="amberAlertText">Message text goes here.</div>
                <div class="amber-alert-actions" id="amberAlertActions">
                    <button type="button" class="amber-alert-btn amber-alert-btn-cancel" id="amberAlertCancelBtn" style="display: none;">Cancel</button>
                    <button type="button" class="amber-alert-btn amber-alert-btn-gold" id="amberAlertConfirmBtn">OK</button>
                </div>
            </div>
        `;

        document.body.appendChild(alertOverlay);
        return alertOverlay;
    }

    const AmberAlert = {
        /**
         * Show an informative custom alert modal
         */
        alert: function (message, options = {}) {
            return new Promise((resolve) => {
                const overlay = buildAlertDOM();
                const titleEl = document.getElementById('amberAlertTitle');
                const textEl = document.getElementById('amberAlertText');
                const iconWrap = document.getElementById('amberAlertIconWrap');
                const iconEl = document.getElementById('amberAlertIcon');
                const confirmBtn = document.getElementById('amberAlertConfirmBtn');
                const cancelBtn = document.getElementById('amberAlertCancelBtn');

                const type = options.type || 'info';
                const title = options.title || (type === 'success' ? 'Success' : (type === 'error' ? 'Notice' : (type === 'warning' ? 'Attention' : "Amber's Roots")));
                const confirmText = options.confirmText || 'OK';

                titleEl.textContent = title;
                textEl.innerHTML = typeof message === 'string' ? message.replace(/\n/g, '<br>') : message;

                // Setup Icon & Style
                iconWrap.className = `amber-alert-icon-wrap type-${type}`;
                confirmBtn.className = 'amber-alert-btn amber-alert-btn-gold';

                if (type === 'success') {
                    iconEl.className = 'fa-solid fa-circle-check';
                } else if (type === 'error') {
                    iconEl.className = 'fa-solid fa-triangle-exclamation';
                    confirmBtn.className = 'amber-alert-btn amber-alert-btn-danger';
                } else if (type === 'warning') {
                    iconEl.className = 'fa-solid fa-circle-exclamation';
                } else {
                    iconEl.className = 'fa-solid fa-gem';
                }

                cancelBtn.style.display = 'none';
                confirmBtn.textContent = confirmText;
                confirmBtn.focus();

                overlay.classList.add('is-active');

                const handleConfirm = () => {
                    cleanup();
                    resolve(true);
                };

                const handleKey = (e) => {
                    if (e.key === 'Escape' || e.key === 'Enter') {
                        cleanup();
                        resolve(true);
                    }
                };

                const cleanup = () => {
                    overlay.classList.remove('is-active');
                    confirmBtn.removeEventListener('click', handleConfirm);
                    document.removeEventListener('keydown', handleKey);
                };

                confirmBtn.addEventListener('click', handleConfirm);
                document.addEventListener('keydown', handleKey);
            });
        },

        /**
         * Show an interactive confirmation modal
         */
        confirm: function (message, options = {}) {
            return new Promise((resolve) => {
                const overlay = buildAlertDOM();
                const titleEl = document.getElementById('amberAlertTitle');
                const textEl = document.getElementById('amberAlertText');
                const iconWrap = document.getElementById('amberAlertIconWrap');
                const iconEl = document.getElementById('amberAlertIcon');
                const confirmBtn = document.getElementById('amberAlertConfirmBtn');
                const cancelBtn = document.getElementById('amberAlertCancelBtn');

                const title = options.title || 'Are you sure?';
                const confirmText = options.confirmText || 'Yes, Proceed';
                const cancelText = options.cancelText || 'Cancel';
                const isDanger = options.isDanger !== false;

                titleEl.textContent = title;
                textEl.innerHTML = typeof message === 'string' ? message.replace(/\n/g, '<br>') : message;

                iconWrap.className = isDanger ? 'amber-alert-icon-wrap type-error' : 'amber-alert-icon-wrap type-confirm';
                iconEl.className = isDanger ? 'fa-solid fa-trash-can' : 'fa-solid fa-circle-question';

                confirmBtn.className = isDanger ? 'amber-alert-btn amber-alert-btn-danger' : 'amber-alert-btn amber-alert-btn-gold';
                confirmBtn.textContent = confirmText;

                cancelBtn.style.display = 'inline-flex';
                cancelBtn.textContent = cancelText;

                overlay.classList.add('is-active');
                confirmBtn.focus();

                const handleConfirm = () => {
                    cleanup();
                    resolve(true);
                };

                const handleCancel = () => {
                    cleanup();
                    resolve(false);
                };

                const handleKey = (e) => {
                    if (e.key === 'Escape') {
                        cleanup();
                        resolve(false);
                    }
                };

                const cleanup = () => {
                    overlay.classList.remove('is-active');
                    confirmBtn.removeEventListener('click', handleConfirm);
                    cancelBtn.removeEventListener('click', handleCancel);
                    document.removeEventListener('keydown', handleKey);
                };

                confirmBtn.addEventListener('click', handleConfirm);
                cancelBtn.addEventListener('click', handleCancel);
                document.addEventListener('keydown', handleKey);
            });
        },

        success: function (message, title = 'Successful') {
            return this.alert(message, { title, type: 'success', confirmText: 'Done' });
        },
        error: function (message, title = 'Attention') {
            return this.alert(message, { title, type: 'error', confirmText: 'Got It' });
        },
        warning: function (message, title = 'Warning') {
            return this.alert(message, { title, type: 'warning', confirmText: 'Understood' });
        },
        info: function (message, title = 'Notice') {
            return this.alert(message, { title, type: 'info', confirmText: 'OK' });
        }
    };

    // -------------------------------------------------------------
    // 3. Global Window Overrides (Seamless backwards compatibility)
    // -------------------------------------------------------------
    // Replace default browser alert()
    window.alert = function (message) {
        AmberAlert.alert(message);
    };

    // Replace default showToast() with the luxury system
    window.showToast = function (message, type = 'success') {
        AmberToast.show(message, type);
    };

    // Expose APIs globally
    window.AmberAlert = AmberAlert;
    window.AmberToast = AmberToast;

    // -------------------------------------------------------------
    // 4. Form onsubmit="return confirm(...)" and [data-confirm] Interceptor
    // -------------------------------------------------------------
    document.addEventListener('DOMContentLoaded', function () {
        // Intercept all forms with onsubmit containing confirm(...) or data-confirm
        const forms = document.querySelectorAll('form');
        forms.forEach(function (form) {
            const onsubmitAttr = form.getAttribute('onsubmit');
            const dataConfirm = form.getAttribute('data-confirm');

            let msg = dataConfirm || null;

            if (onsubmitAttr && onsubmitAttr.includes('confirm(')) {
                const match = onsubmitAttr.match(/confirm\s*\(\s*['"](.*?)['"]\s*\)/);
                if (match && match[1]) {
                    msg = match[1];
                }
                form.removeAttribute('onsubmit');
            }

            if (msg) {
                form.addEventListener('submit', function (e) {
                    if (form.dataset.amberConfirmed === 'true') {
                        return true;
                    }

                    e.preventDefault();
                    e.stopPropagation();

                    const isDelete = form.action.includes('delete') || form.action.includes('kick') || (onsubmitAttr && onsubmitAttr.toLowerCase().includes('delete')) || msg.toLowerCase().includes('delete');

                    AmberAlert.confirm(msg, {
                        title: isDelete ? 'Confirm Deletion' : 'Please Confirm',
                        confirmText: isDelete ? 'Yes, Delete' : 'Confirm',
                        cancelText: 'Cancel',
                        isDanger: isDelete
                    }).then(function (confirmed) {
                        if (confirmed) {
                            form.dataset.amberConfirmed = 'true';
                            form.submit();
                        }
                    });
                });
            }
        });
    });

})(window, document);
