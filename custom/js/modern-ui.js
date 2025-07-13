/**
 * Modern UI Enhancement Script for Pharma Vault
 * Provides enhanced interactions and user experience improvements
 */

$(document).ready(function() {
    // Debug: Check for duplicate table IDs
    var tableIds = {};
    $('table[id]').each(function() {
        var id = $(this).attr('id');
        if (tableIds[id]) {
            console.warn('Duplicate table ID found: ' + id);
            tableIds[id]++;
        } else {
            tableIds[id] = 1;
        }
    });
    
    // Initialize tooltips for better UX
    $('[data-toggle="tooltip"]').tooltip();
    
    // Enhanced dropdown management for action buttons
    setupDropdownManagement();
    
    // Enhanced table interactions - only initialize if not already initialized
    if ($.fn.DataTable) {
        // Configure modern DataTables only for tables that aren't already initialized
        $('.table').each(function() {
            var $table = $(this);
            var tableId = $table.attr('id');
            
            // Skip tables that are handled by specific page scripts or have common IDs
            var skipTables = ['manageProductTable', 'manageBrandTable', 'manageCategoriesTable', 'manageOrderTable', 'productTable', 'editProductTable', 'userPerformanceTable'];
            if (skipTables.includes(tableId)) {
                return; // Skip this table
            }
            
            // Additional check for duplicate IDs (multiple tables with same ID)
            if (tableId && $('table#' + tableId).length > 1) {
                console.warn('Multiple tables found with ID: ' + tableId + '. Skipping DataTable initialization to prevent conflicts.');
                return; // Skip if duplicate IDs exist
            }
            
            // Check if DataTable is already initialized
            if (!$.fn.DataTable.isDataTable($table)) {
                try {
                    // Only initialize if it's not a DataTable yet
                    $table.DataTable({
                        responsive: true,
                        pageLength: 25,
                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        language: {
                            search: "Search:",
                            lengthMenu: "Show _MENU_ entries",
                            info: "Showing _START_ to _END_ of _TOTAL_ entries",
                            paginate: {
                                previous: "‹ Previous",
                                next: "Next ›"
                            }
                        },
                        drawCallback: function() {
                            // Add modern styling to table elements
                            $('.dataTables_paginate .paginate_button').addClass('modern-paginate');
                        }
                    });
                } catch (error) {
                    console.warn('Failed to initialize DataTable for table ID: ' + tableId, error);
                }
            }
        });
    }

    // Enhanced button interactions
    $('.btn').on('click', function(e) {
        var $btn = $(this);
        
        // Skip loading for certain buttons
        if ($btn.hasClass('no-loading') || $btn.data('toggle') === 'modal') {
            return;
        }
        
        // Add loading state for form submissions
        if ($btn.attr('type') === 'submit') {
            e.preventDefault();
            var form = $btn.closest('form');
            var originalText = $btn.html();
            
            $btn.html('<i class="fa fa-spinner fa-spin"></i> Processing...');
            $btn.prop('disabled', true);
            
            // Submit form after showing loading state
            setTimeout(function() {
                form.submit();
            }, 300);
        }
    });

    // Auto-hide alerts
    $('.alert').delay(5000).fadeOut();

    // Enhanced form validation
    $('input, select, textarea').on('invalid', function() {
        $(this).addClass('is-invalid');
        $(this).on('input change', function() {
            $(this).removeClass('is-invalid');
        });
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

    // Enhanced modal interactions
    $('.modal').on('show.bs.modal', function() {
        $(this).find('.form-control:first').focus();
    });

    // Card hover effects
    $('.stat-card, .card, .panel').hover(
        function() {
            $(this).addClass('shadow-hover');
        },
        function() {
            $(this).removeClass('shadow-hover');
        }
    );

    // Enhanced search functionality
    $('input[type="search"], .dataTables_filter input').on('keyup', function() {
        var $this = $(this);
        var value = $this.val();
        
        if (value.length > 0) {
            $this.addClass('has-value');
        } else {
            $this.removeClass('has-value');
        }
    });

    // Status badge enhancements
    $('.badge, .label').each(function() {
        var $badge = $(this);
        var text = $badge.text().toLowerCase();
        
        if (text.includes('active') || text.includes('available')) {
            $badge.addClass('badge-success');
        } else if (text.includes('inactive') || text.includes('unavailable')) {
            $badge.addClass('badge-danger');
        } else if (text.includes('pending')) {
            $badge.addClass('badge-warning');
        }
    });

    // Image lazy loading for product images
    $('img[data-src]').each(function() {
        var $img = $(this);
        $img.attr('src', $img.data('src'));
    });

    // Modern notification system
    window.showNotification = function(message, type = 'success') {
        var alertClass = 'alert-' + type;
        var icon = type === 'success' ? 'fa-check' : 
                   type === 'danger' ? 'fa-exclamation-triangle' : 
                   type === 'warning' ? 'fa-warning' : 'fa-info';
        
        var notification = $(`
            <div class="alert ${alertClass} alert-dismissible modern-notification" style="display: none;">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fa ${icon}"></i> ${message}
            </div>
        `);
        
        $('.container-fluid').prepend(notification);
        notification.slideDown();
        
        setTimeout(function() {
            notification.slideUp(function() {
                $(this).remove();
            });
        }, 5000);
    };

    // Enhanced table row selection
    $('.table tbody tr').on('click', function(e) {
        if (!$(e.target).is('button, a, input')) {
            $(this).toggleClass('selected');
        }
    });

    // Quick actions keyboard shortcuts
    $(document).keydown(function(e) {
        // Ctrl/Cmd + N for new item
        if ((e.ctrlKey || e.metaKey) && e.which === 78) {
            e.preventDefault();
            $('[data-toggle="modal"]:first').trigger('click');
        }
        
        // Escape to close modals
        if (e.which === 27) {
            $('.modal').modal('hide');
        }
    });

    // Progressive enhancement for older browsers
    if (!CSS.supports('display', 'grid')) {
        $('.row').addClass('fallback-flex');
    }

    // Loading state for page transitions
    $(window).on('beforeunload', function() {
        $('body').addClass('page-loading');
    });

    // Initialize custom components
    initializeCustomComponents();
    
    // Apply modern styling to existing DataTables (initialized by other scripts)
    setTimeout(function() {
        applyModernDataTableStyling();
    }, 1000);
});

function applyModernDataTableStyling() {
    // Apply modern styling to any existing DataTables
    $('.dataTables_wrapper').each(function() {
        var $wrapper = $(this);
        
        try {
            // Style the search input
            var $searchInput = $wrapper.find('.dataTables_filter input');
            if ($searchInput.length && !$searchInput.hasClass('modern-styled')) {
                $searchInput.addClass('form-control modern-styled').attr({
                    'placeholder': 'Search...',
                    'style': 'border: 2px solid var(--gray-200); border-radius: var(--radius-md); padding: 8px 12px; margin-left: 8px;'
                });
            }
            
            // Style the length select
            var $lengthSelect = $wrapper.find('.dataTables_length select');
            if ($lengthSelect.length && !$lengthSelect.hasClass('modern-styled')) {
                $lengthSelect.addClass('form-control modern-styled').attr({
                    'style': 'border: 2px solid var(--gray-200); border-radius: var(--radius-md); padding: 4px 8px; width: auto; display: inline-block;'
                });
            }
            
            // Style pagination buttons
            var $paginateButtons = $wrapper.find('.dataTables_paginate .paginate_button');
            if ($paginateButtons.length && !$paginateButtons.hasClass('modern-styled')) {
                $paginateButtons.addClass('modern-styled').attr({
                    'style': 'border-radius: var(--radius-sm) !important; margin: 0 2px !important; border: 1px solid var(--gray-300) !important; padding: 6px 12px !important;'
                });
            }
        } catch (error) {
            console.warn('Error applying modern DataTable styling:', error);
        }
    });
}

function initializeCustomComponents() {
    // Custom dropdown enhancements
    $('.dropdown-toggle').on('shown.bs.dropdown', function() {
        $(this).find('.caret').addClass('open');
    }).on('hidden.bs.dropdown', function() {
        $(this).find('.caret').removeClass('open');
    });

    // Form field focus enhancements
    $('.form-control').on('focus', function() {
        $(this).closest('.form-group').addClass('focused');
    }).on('blur', function() {
        $(this).closest('.form-group').removeClass('focused');
    });

    // Enhanced file upload visualization
    $('input[type="file"]').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.file-name').text(fileName || 'No file chosen');
    });
}

/**
 * Setup enhanced dropdown management for action buttons
 * Ensures proper visibility and behavior of dropdown menus in tables
 */
function setupDropdownManagement() {
    // Handle dropdown toggle clicks
    $(document).on('click', '[data-toggle="dropdown"]', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var $this = $(this);
        var $dropdown = $this.closest('.btn-group');
        var isOpen = $dropdown.hasClass('open');
        
        // Close all other dropdowns first
        $('.btn-group.open').removeClass('open');
        
        // Toggle current dropdown
        if (!isOpen) {
            $dropdown.addClass('open');
            
            // Ensure dropdown is positioned correctly and visible
            var $menu = $dropdown.find('.dropdown-menu');
            if ($menu.length) {
                // Reset any transform styles that might interfere
                $menu.css({
                    'transform': 'none',
                    'position': 'absolute',
                    'z-index': '9999',
                    'visibility': 'visible',
                    'opacity': '1'
                });
                
                // Check if dropdown would be cut off and adjust position if needed
                var dropdownOffset = $menu.offset();
                var dropdownHeight = $menu.outerHeight();
                var windowHeight = $(window).height();
                var scrollTop = $(window).scrollTop();
                
                if (dropdownOffset.top + dropdownHeight > windowHeight + scrollTop) {
                    $menu.css('top', 'auto').css('bottom', '100%');
                }
            }
        }
    });
    
    // Close dropdowns when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.btn-group').length) {
            $('.btn-group.open').removeClass('open');
        }
    });
    
    // Handle dropdown menu item clicks
    $(document).on('click', '.btn-group.open .dropdown-menu a', function(e) {
        // Let the default action proceed (edit, remove, etc.)
        // But close the dropdown after a short delay
        setTimeout(function() {
            $('.btn-group.open').removeClass('open');
        }, 100);
    });
    
    // Ensure dropdowns remain visible during DataTables redraws
    if ($.fn.DataTable) {
        $(document).on('draw.dt', '.dataTable', function() {
            // Re-attach dropdown handlers after DataTable redraw
            setTimeout(function() {
                setupDropdownHandlers();
            }, 100);
        });
    }
}

/**
 * Setup dropdown handlers for dynamically loaded content
 */
function setupDropdownHandlers() {
    // This function can be called after DataTable redraws or AJAX content loads
    // to ensure dropdown functionality is maintained
    
    // Ensure all dropdown buttons have proper attributes
    $('[data-toggle="dropdown"]').each(function() {
        var $this = $(this);
        if (!$this.attr('aria-haspopup')) {
            $this.attr('aria-haspopup', 'true');
            $this.attr('aria-expanded', 'false');
        }
    });
}

// Additional CSS for enhanced interactions
var enhancedStyles = `
<style>
.shadow-hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg) !important;
    transition: var(--transition-normal);
}

.modern-notification {
    position: fixed;
    top: 80px;
    right: 20px;
    z-index: 9999;
    min-width: 300px;
    border-radius: var(--radius-lg);
    border: none;
}

.has-value {
    background-color: var(--primary-50);
    border-color: var(--primary-300);
}

.focused {
    position: relative;
}

.focused::before {
    content: '';
    position: absolute;
    left: -2px;
    top: -2px;
    right: -2px;
    bottom: -2px;
    border: 2px solid var(--primary-200);
    border-radius: var(--radius-md);
    pointer-events: none;
}

.selected {
    background-color: var(--primary-50) !important;
}

.page-loading {
    pointer-events: none;
    opacity: 0.7;
}

.modern-paginate {
    margin: 0 2px;
    border-radius: var(--radius-sm);
}

.fallback-flex {
    display: flex;
    flex-wrap: wrap;
}

.badge-success {
    background-color: var(--success-500) !important;
}

.badge-danger {
    background-color: var(--danger-500) !important;
}

.badge-warning {
    background-color: var(--warning-500) !important;
}
</style>
`;

$('head').append(enhancedStyles);
