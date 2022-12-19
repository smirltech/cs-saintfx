<!-- menu  -->
<div id="nav" class="nav-container d-flex">
    <div class="nav-content d-flex">
        <div class="logo position-relative">
            <a href="{{route('home')}}">
                <div class="img"></div>
            </a>
        </div>
        <div class="user-container d-flex">
            <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                <img class="profile" alt="{{ Auth::user()->name }}" src="{{ asset(Auth()->user()->image()) }}">
                <div class="name">{{ Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-end user-menu wide">
                <div class="row mb-3 ms-0 me-0">
                    <div class="col-12 ps-1 mb-2">
                        <div class="text-extra-small text-primary">ACCOUNT</div>
                    </div>
                    <div class="col-6 ps-1 pe-1">
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{route('scolarite.users.edit',Auth::user())}}">{{ Auth::user()->name }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 pe-1 ps-1">
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{route('companies.edit',Auth::user()->company)}}">{{Auth::user()->company->name}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row mb-1 ms-0 me-0">
                    <div class="col-12 p-1 mb-3 pt-3">
                        <div class="separator-light"></div>
                    </div>
                    <div hidden class="col-6 ps-1 pe-1">
                        <ul class="list-unstyled">
                            <li>
                                <a href="#">
                                    <i data-cs-icon="help" class="me-2" data-cs-size="17"></i>
                                    <span class="align-middle">Help</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i data-cs-icon="file-text" class="me-2" data-cs-size="17"></i>
                                    <span class="align-middle">Docs</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 pe-1 ps-1">
                        <ul class="list-unstyled">
                            <li hidden>
                                <a href="#">
                                    <i data-cs-icon="gear" class="me-2" data-cs-size="17"></i>
                                    <span class="align-middle">Settings</span>
                                </a>
                            </li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i data-cs-icon="logout" class="me-2" data-cs-size="17"></i>
                                    <span class="align-middle">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <ul class="list-unstyled list-inline text-center menu-icons">
            <li class="list-inline-item">
                <a href="#" data-bs-toggle="modal" data-bs-target="#searchPagesModal">
                    <i data-cs-icon="search" data-cs-size="18"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#" id="pinButton" class="pin-button">
                    <i data-cs-icon="lock-on" class="unpin" data-cs-size="18"></i>
                    <i data-cs-icon="lock-off" class="pin" data-cs-size="18"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#" id="colorButton">
                    <i data-cs-icon="light-on" class="light" data-cs-size="18"></i>
                    <i data-cs-icon="light-off" class="dark" data-cs-size="18"></i>
                </a>
            </li>
        </ul>
        <div class="menu-container flex-grow-1">
            <ul id="menu" class="menu">
                <li>
                    <a href="{{ route('home') }}">
                        <i data-cs-icon="shop" class="icon" data-cs-size="18"></i>
                        <span class="label">{{__('home')}}</span>
                    </a>
                </li>
                <li>
                    <a href="#products" data-href="Products.html">
                        <i data-cs-icon="cupcake" class="icon" data-cs-size="18"></i>
                        <span class="label">Produits</span>
                    </a>
                    <ul id="products">
                        <li>
                            <a href="{{route('items.create')}}">
                                <span class="label">{{__('Add')}}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('items.index')}}">
                                <span class="label">{{__('Catalogue')}}</span>
                            </a>
                        </li>
                        <li hidden>
                            <a href="#">
                                <span class="label">{{__('Services')}}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('categories.index')}}">
                                <span class="label">{{__('Categories')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#orders" data-href="Orders.html">
                        <i data-cs-icon="cart" class="icon" data-cs-size="18"></i>
                        <span class="label">{{__('Ventes')}}</span>
                    </a>
                    <ul id="orders">
                        <li hidden>
                            <a href="{{route('sellings.index')}}">
                                <span class="label">Commandes</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('rapports')}}">
                                <span class="label">Rapports</span>
                            </a>
                        </li>

                        <li hidden>
                            <a href="#">
                                <span class="label">Clients</span>
                            </a>
                        </li>
                        <li hidden>
                            <a href="{{route('pos')}}">
                                <span class="label">POS</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('scolarite.users.index')}}">
                        <i data-cs-icon="user" class="icon" data-cs-size="18"></i>
                        <span class="label">{{__('Users')}}</span>
                    </a>
                </li>
                <li hidden>
                    <a href="#">
                        <i data-cs-icon="shipping" class="icon" data-cs-size="18"></i>
                        <span class="label">Livraison</span>
                    </a>
                </li>
                <li hidden>
                    <a href="#">
                        <i data-cs-icon="tag" class="icon" data-cs-size="18"></i>
                        <span class="label">Discount</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('companies.edit',Auth::user()->company)}}">
                        <i data-cs-icon="gear" class="icon" data-cs-size="18"></i>
                        <span class="label">{{Auth::user()->company->name}}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="mobile-buttons-container">
            <a href="#" id="mobileMenuButton" class="menu-button">
                <i data-cs-icon="menu"></i>
            </a>
        </div>
    </div>
    <div class="nav-shadow"></div>
</div>
<!--/ menu  -->
