        </div> <!-- container-fluid -->
    </div> <!-- dashboard-container -->

    <!-- Modern Footer -->
    <footer style="background: var(--gray-900); color: white; padding: 24px 0; border-top: 1px solid var(--gray-200);">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p style="margin: 0; font-size: 14px;">
                        <i class="fa fa-copyright"></i> 2025 Pharma Vault. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-right">
                    <p style="margin: 0; font-size: 14px; color: var(--gray-400);">
                        Powered by Modern Technology
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- File Input -->
    <script src="assests/plugins/fileinput/js/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
    <script src="assests/plugins/fileinput/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="assests/plugins/fileinput/js/plugins/purify.min.js" type="text/javascript"></script>
    <script src="assests/plugins/fileinput/js/fileinput.min.js"></script>

    <!-- DataTables -->
    <script src="assests/plugins/datatables/jquery.dataTables.min.js"></script>

    <!-- Modern UI Enhancements -->
    <script src="custom/js/modern-ui.js"></script>

    <!-- Enhanced Interactions -->
    <script>
        $(document).ready(function() {
            // Enhanced DataTables
            if ($.fn.DataTable) {
                $('.table').DataTable({
                    responsive: true,
                    pageLength: 25,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    language: {
                        search: "Search:",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        paginate: {
                            previous: "Previous",
                            next: "Next"
                        }
                    }
                });
            }

            // Button loading states
            $('.btn').on('click', function() {
                var $btn = $(this);
                if (!$btn.hasClass('no-loading') && $btn.attr('type') === 'submit') {
                    var originalText = $btn.html();
                    $btn.html('<i class="fa fa-spinner fa-spin"></i> Processing...');
                    $btn.prop('disabled', true);
                    
                    setTimeout(function() {
                        $btn.html(originalText);
                        $btn.prop('disabled', false);
                    }, 3000);
                }
            });

            // Enhanced tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Auto-hide alerts
            $('.alert').delay(5000).fadeOut();

            // Form validation feedback
            $('input, select, textarea').on('invalid', function() {
                $(this).addClass('is-invalid');
            }).on('input change', function() {
                $(this).removeClass('is-invalid');
            });

            // Active navigation highlighting
            var currentPage = window.location.pathname.split('/').pop();
            $('.navbar-nav a').each(function() {
                var href = $(this).attr('href');
                if (href && href.indexOf(currentPage) !== -1) {
                    $(this).parent().addClass('active');
                }
            });

            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 800);
                }
            });
        });
    </script>

    <style>
        /* Additional modern styles */
        .is-invalid {
            border-color: var(--danger-500) !important;
            box-shadow: 0 0 0 3px rgb(239 68 68 / 0.1) !important;
        }
        
        /* Override Bootstrap table striping for modern look */
        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: transparent;
        }
        
        /* Modern focus states */
        .form-control:focus,
        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--primary-500) !important;
            box-shadow: 0 0 0 3px rgb(14 165 233 / 0.1) !important;
            outline: none !important;
        }
        
        /* Enhanced button states */
        .btn:focus {
            box-shadow: 0 0 0 3px rgb(14 165 233 / 0.2) !important;
        }
        
        /* Modal enhancements */
        .modal-content {
            border-radius: var(--radius-lg) !important;
            border: none !important;
        }
        
        .modal-header {
            border-bottom: 1px solid var(--gray-200) !important;
            background: var(--gray-50) !important;
        }
        
        .modal-footer {
            border-top: 1px solid var(--gray-200) !important;
            background: var(--gray-50) !important;
        }
    </style>
</body>
</html>