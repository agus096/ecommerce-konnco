<div class="site-navbar bg-white py-2">
    <div class="search-wrap">
      <div class="container">
        <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
        <form action="#" method="post">
          <input type="text" class="form-control" placeholder="Search keyword and hit enter...">
        </form>
      </div>
    </div>

    <div class="container">
      <div class="d-flex align-items-center justify-content-between">
        <div class="logo">
          <div class="site-logo">
            <a href="index.html" class="js-logo-clone">ShopMax</a>
          </div>
        </div>
        <div class="main-nav d-none d-lg-block">
          <nav class="site-navigation text-right text-md-center" role="navigation">
            <ul class="site-menu js-clone-nav d-none d-lg-block">
              @auth
                  @if (auth()->user()->role === 'admin')
                      <li>
                          <a href="{{ route('admin.dashboard') }}">Admin page</a>
                      </li>
                  @endif
              @endauth
              <li>
                <a href="logout">Logout</a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="icons">
          <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span
              class="icon-menu"></span>
          </a>
        </div>
      </div>
    </div>
</div>