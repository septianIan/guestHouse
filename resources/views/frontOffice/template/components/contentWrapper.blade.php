<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="overflow-y:auto;height:400px;">
   <!-- Content Header (Page header) -->
   <div class="content-header">
         <div class="container-fluid">
            <div class="row mb-2">
               <div class="col-sm-6">
                  <h1 class="m-0 text-dark">
                     @yield('title')
                  </h1>
               </div><!-- /.col -->
               <div class="col-sm-6">
                  @yield('breadcrumb')
               </div>
            </div>
         </div>
   </div>
   @yield('content')
</div>