<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <router-link to="/" class="navbar-brand">
                           Mini-Admin
                        </router-link>
              
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto" >
                        <router-link to="/employees" class="nav-link"  exact active-class="active" >
                            <li class="nav-item">Employee
                                </li>
                        </router-link>
                        <router-link to="/companies" class="nav-link" exact active-class="active">
                            <li class="nav-item">Companies
                                </li>
                        </router-link>
                    </ul>
                    <ul class="navbar-nav ms-auto" >
                        <li class="nav-item dropdown">
                                <a   href="logout"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                    <form id="logout-form" action="logout" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>
</template>

<style>

.active{
    color: white !important;
    background-color: black;
}
</style>