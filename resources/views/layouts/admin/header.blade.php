<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
                <div class="header-left d-flex align-items-center">
                    <div class="menu-toggle-btn mr-15">
                        <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                            <i class="lni lni-chevron-left me-2"></i> Menu
                        </button>
                    </div>
                    <div class="header-search d-none d-md-flex position-relative">
                        <form action="javascript:void(0)">
                            <input type="text" id="adminSearch" class="form-control" placeholder="Search menu..."
                                autocomplete="off" />
                            <button type="button">
                                <i class="lni lni-search-alt"></i>
                            </button>
                        </form>

                        <div id="searchResultCard" class="card position-absolute d-none"
                            style="top: 45px; width: 100%; z-index: 999;">
                            <div class="list-group list-group-flush" id="searchResultList"></div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
                <div class="header-right">
                    <!-- Notification Start -->
                    <div class="dropdown d-none d-md-flex ms-3">

                        <button class="btn position-relative p-0 border-0 bg-transparent" type="button"
                            id="notification" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bell fs-5"></i>

                            @if (!empty($notifications) && $notifications->count())
                                <span id="notification-count"
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="height: 1.2rem; width: 1.2rem; display: flex; align-items: center; justify-content: center;">
                                    {{ $notifications->count() }}
                                </span>
                            @endif

                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notification"
                            style="width: 320px;">

                            <li class="dropdown-header fw-semibold">
                                Notifications
                            </li>

                            {{-- @forelse ($notifications as $notification)
                                <li>
                                    <a href=" {{ route('admin.notification.index', ['notification_id' => $notification->id]) }} "
                                        class="dropdown-item d-flex align-items-start gap-2">

                                        <img src="{{ $notification->user?->image
                                            ? asset('storage/admin/customer/' . $notification->user->image)
                                            : asset('assets/images/profile/profile.png') }}"
                                            class="rounded-circle" width="40" height="40" alt="User">

                                        <div class="flex-grow-1 overflow-hidden">
                                            <div class="fw-semibold small text-truncate">
                                                {{ ucfirst($notification->type) }}
                                            </div>

                                            <div class="text-muted small text-wrap text-break">
                                                {{ $notification->message }}
                                            </div>

                                            <div class="text-muted small">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </a>

                                </li>
                            @empty
                                <li class="text-center text-muted py-3">
                                    No new notifications
                                </li>
                            @endforelse --}}
                        </ul>
                    </div>
                    <!-- Notification End -->


                    <!-- profile start -->
                    <div class="profile-box ml-15">
                        <button class="btn p-0 border-0 bg-transparent dropdown-toggle" type="button" id="profile"
                            data-bs-toggle="dropdown" aria-expanded="false">

                            <div class="d-flex align-items-center gap-2">

                                <!-- Profile Image Wrapper -->
                                <div class="position-relative d-inline-block">
                                    <img src="{{ Auth::guard('web')->user()->profile_image ?? asset('assets/images/profile/profile-image.png') }}"

                                        alt="{{ Auth::guard('web')->user()->name }} "
                                        class="rounded-circle border"
                                        style="width:42px;height:42px;object-fit:cover;" />

                                    <!-- Status Indicator -->
                                    <span
                                        class="position-absolute bottom-0 end-0 border border-white rounded-circle
                                        {{ Auth::guard('web')->user()->status == 1 ? 'bg-success' : 'bg-danger' }}"
                                        style="width:12px;height:12px;">
                                    </span>
                                </div>


                                <!-- Optional Name (Desktop only) -->
                                <div class="d-none d-md-block text-start">
                                    <div class="fw-semibold text-dark">
                                        {{ Auth::guard('web')->user()->name }}

                                    </div>
                                    <small class="text-muted">{{ ucfirst(Auth::guard('web')->user()->role_name) }}</small>
                                </div>

                            </div>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                            <li>
                                <div class="author-info flex items-center !p-1">
                                    <div class="image">
                                        <img src="{{ Auth::guard('web')->user()->profile_image ?? asset('assets/images/profile/profile-image.png') }}"
                                            alt="image">
                                    </div>
                                    <div class="content">
                                        <h4 class="text-sm">
                                            {{ Auth::guard('web')->user()->name }}

                                        </h4>
                                        <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white  text-xs text-muted small text-wrap text-break"
                                            href="#">{{ Auth::guard('web')->user()->email }}</a>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            {{-- <li>
                                <a href="#0">
                                    <i class="lni lni-user"></i> View Profile
                                </a>
                            </li> --}}

                            {{-- @if (Auth::guard('admin')->user()->role_id == 1)
                                <li>
                                    <a href="{{ route('admin.web_config.') }}"> <i class="lni lni-cog"></i>
                                        {{ trans('messages.Settings') }} </a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('admin.users.edit', Auth::guard('admin')->user()->id ?? '') }}">
                                        <i class="lni lni-user"></i> {{ trans('messages.my_profile') }} </a>
                                </li>
                            @endif
                            <li class="divider"></li> --}}
                            <li>
                                <a href="{{ route('admin.logout') }}" class="btn logoutBtn"> <i
                                        class="lni lni-exit"></i>
                                    Sign Out </a>
                            </li>
                        </ul>
                    </div>
                    <!-- profile end -->
                </div>
            </div>
        </div>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutBtn = document.querySelector('.logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                swal.fire({
                    title: 'Confirm Logout',
                    text: 'Are you sure you want to sign out?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, sign out',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = this.href;
                    }
                });
            });
        }
    });
</script>
{{-- <script>
    const menuItems = [

        // Dashboard
        {
            name: "Dashboard",
            url: "{{ route('admin.dashboard') }}"
        },

        // User / Staff
        {
            name: "Employees",
            url: "{{ route('admin.users.index') }}"
        },

        // Customers
        {
            name: "Customers",
            url: "{{ route('admin.customer.index') }}"
        },
        {
            name: "Customer Addresses",
            url: "{{ route('admin.customer.address.index') }}"
        },

        // POS
        {
            name: "POS Users",
            url: "{{ route('admin.pos.user.index') }}"
        },

        // Brand
        {
            name: "Brands",
            url: "{{ route('admin.brand.index') }}"
        },

        // Category
        {
            name: "Categories",
            url: "{{ route('admin.category.index') }}"
        },

        // Seller
        {
            name: "Sellers",
            url: "{{ route('admin.seller.index') }}"
        },

        // Tags
        {
            name: "Tags",
            url: "{{ route('admin.tag.index') }}"
        },

        // Attributes
        {
            name: "Attributes",
            url: "{{ route('admin.attribute.index') }}"
        },

        // Products
        {
            name: "Products",
            url: "{{ route('admin.product.index') }}"
        },
        {
            name: "Product Reviews",
            url: "{{ route('admin.product.review') }}"
        },
        {
            name: "Wishlist",
            url: "{{ route('admin.product.wish-list') }}"
        },
        {
            name: "Inventory Track",
            url: "{{ route('admin.product.inventory-track') }}"
        },

        // Coupons
        {
            name: "Coupons",
            url: "{{ route('admin.coupon.index') }}"
        },

        // Orders
        {
            name: "Orders",
            url: "{{ route('admin.order.index') }}"
        },
        {
            name: "Order Status",
            url: "{{ route('admin.order-status.index') }}"
        },
        {
            name: "Order Messages",
            url: "{{ route('admin.order-messages.index') }}"
        },

        // Shipping
        {
            name: "Shipping Methods",
            url: "{{ route('admin.shipping-method.index') }}"
        },

        // Testimonials
        {
            name: "Testimonials",
            url: "{{ route('admin.testimonial.index') }}"
        },

        // Banner
        {
            name: "Banners",
            url: "{{ route('admin.banner.list') }}"
        },

        // Currency
        {
            name: "Currencies",
            url: "{{ route('admin.currency.view') }}"
        },

        // Payment
        {
            name: "Payment Methods",
            url: "{{ route('admin.payment-method.index') }}"
        },

        // Notifications
        {
            name: "Notifications",
            url: "{{ route('admin.notification.index') }}"
        },

        // Static Pages
        {
            name: "Static Pages",
            url: "{{ route('admin.static-page.index') }}"
        },

        // Blog
        {
            name: "Blog Posts",
            url: "{{ route('admin.blog.index') }}"
        },
        {
            name: "Blog Categories",
            url: "{{ route('admin.blog-category.index') }}"
        },
        {
            name: "Blog Tags",
            url: "{{ route('admin.blog-tag.index') }}"
        },
        // Store Management
        {
            name: "Store Management",
            url: "{{ route('admin.pos.store.index') }}"
        },
        {
            name: "Store Inventory",
            url: "{{ route('admin.pos.inventory-tracking') }}"
        },
        // Web Setting
        {
            name: "Web Settings",
            url: "{{ route('admin.web_config.') }}"
        },
        // Mail Settings
        {
            name: "Mail Settings",
            url: "{{ route('admin.mail_config.') }}"
        },
        // Firebase Settings
        {
            name: "Firebase Settings",
            url: "{{ route('admin.firebase_config.') }}"
        }


    ];
</script>
<script>
    const searchInput = document.getElementById("adminSearch");
    const resultCard = document.getElementById("searchResultCard");
    const resultList = document.getElementById("searchResultList");

    searchInput.addEventListener("keyup", function() {
        const keyword = this.value.toLowerCase().trim();
        resultList.innerHTML = "";

        if (!keyword) {
            resultCard.classList.add("d-none");
            return;
        }

        const filtered = menuItems.filter(item =>
            item.name.toLowerCase().includes(keyword)
        );

        if (filtered.length === 0) {
            resultList.innerHTML = `
            <div class="list-group-item text-muted">
                No result found
            </div>
        `;
        } else {
            filtered.forEach(item => {
                resultList.innerHTML += `
                <a href="${item.url}"
                   class="list-group-item list-group-item-action">
                    ${item.name}
                </a>
            `;
            });
        }

        resultCard.classList.remove("d-none");
    });

    // Click outside → hide
    document.addEventListener("click", function(e) {
        if (!e.target.closest(".header-search")) {
            resultCard.classList.add("d-none");
        }
    });
</script> --}}
