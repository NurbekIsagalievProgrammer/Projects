<template>
    <div>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                    data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Navbar brand -->
                    <a class="navbar-brand mt-2 mt-lg-0" href="#">
                        <img src="https://mdbcdn.b-cdn.net/img/logo/mdb-transaprent-noshadows.webp" height="15"
                            alt="MDB Logo" loading="lazy" />
                    </a>
                    <!-- Left links -->
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" style="text-transform: none;" type="button" data-bs-toggle="dropdown" aria-expanded="false">Меню</button>
                        <ul class="dropdown-menu" >
                            <li><a class="dropdown-item" href="/recycler">RecyclerComponent</a></li>
                            <li><a class="dropdown-item" href="/recyclerTheme">RecyclerThemes</a></li>
                            <li><a class="dropdown-item" href="/recyclerSolution">RecyclerSolutions</a></li>
                            <li><a class="dropdown-item" href="/recyclerRequest">RecyclerRequests</a></li>
                        </ul>
                    </div>
                    <!-- Left links -->
                </div>
                <!-- Collapsible wrapper -->
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
    </div>
    <div id="main">
        <router-view class="m-3"></router-view>
    </div>
</template>

<script>

export default {
    mounted() {

    },


}

</script>