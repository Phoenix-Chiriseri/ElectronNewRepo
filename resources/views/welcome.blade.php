<x-layout bodyClass="">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <x-navbars.navs.guest signup='register' signin='login'></x-navbars.navs.guest>
            </div>
        </div>
    </div>
    <div class="page-header justify-content-center min-vh-100"
    style="background-image: url('/assets/img/swipe.jpg'); background-size: cover;">
   <span class="mask bg-gradient-dark opacity-6"></span>
   <div class="container" style="background-color:white;border-radius:22px;">
       <h3 class="text-center" style="color:black;">Welcome to Electron Point Of Sale</h3>
   </div>
   </div>
</x-layout>
