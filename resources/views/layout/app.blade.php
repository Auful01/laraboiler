<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <link rel="stylesheet" href="{{asset('dashboard/css/index.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script src="https://kit.fontawesome.com/5f712d1a25.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>BosQu | Web Admin</title>
</head>

<body>

    <div class="screen-cover d-none d-xl-none"></div>

    <div class="row">
        <div class="col-12 col-lg-3 col-navbar d-block">

            <nav class="navbar navbar-dark bg-light shadow navbar-expand d-md-none d-lg-none d-xl-none fixed-bottom">
                <ul class="navbar-nav nav-justified w-100">
                  <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fas fa-home" style="color: rgb(73, 72, 72)" ></i></a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fas fa-search" style="color: rgb(73, 72, 72)"></i></a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fas fa-plus" style="color: rgb(73, 72, 72)"></i></a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fas fa-bell" style="color: rgb(73, 72, 72)"></i></a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fas fa-user" style="color: rgb(73, 72, 72)"></i></a>
                  </li>
                </ul>
              </nav>
            <aside class="sidebar">
                <div class="d-flex flex-column justify-content-center align-items-center">

                    <button id="toggle-navbar" onclick="toggleNavbar()">
                        <!-- <img src="./assets/img/global/navbar-times.svg" class="" alt=""> -->
                        <i class="fas fa-times"></i>
                    </button>

                    <div class="profile-img">
                        <img src="https://placeimg.com/480/480/tech" style="clip-path: circle()" alt="">
                    </div>
                    <h4 class="profile-name">{{Auth::user()->nama}}</h4>
                    <p class="profile-email">{{Auth::user()->email}}</p>
                </div>

                


                <div class="sidebar-item-container">

                    @include('layout.sidebar')
                </div>
            </aside>

        </div>

        <div class="col-12 col-xl-9">
            <div class="nav">
                <div class="d-flex justify-content-between align-items-center w-100 mb-3 mb-md-0">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <h2 class="nav-title" id="title" data-aos="fade-up"></h2>
                        <button id="toggle-navbar" onclick="toggleNavbar()">
                            <img src="https://placeimg.com/480/480/tech" alt="">
                        </button>
                    </div>
                </div>

            </div>

            <div class="content">
                {{-- @yield('content') --}}

            </div>
        </div>
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        {{-- <span aria-hidden="true">×</span> --}}
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ url('/signout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ url('/signout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        const navbar = document.querySelector('.col-navbar')
        const cover = document.querySelector('.screen-cover')

        const sidebar_items = document.querySelectorAll('.sidebar-item')

        function toggleNavbar() {
            navbar.classList.toggle('appear')
            cover.classList.toggle('d-none')
        }

        function toggleActive(e) {
            sidebar_items.forEach(function(v, k) {
                v.classList.remove('active')
            })
            e.closest('.sidebar-item').classList.add('active')

        }

        // Table List
        // const buttons = document.querySelectorAll('.btn-transaction')
        // const tables = document.querySelectorAll('.transaction-table')

        // const resetButtons = () => buttons.forEach((v,k) => v.classList.remove('active'))
        // const resetTables = () => tables.forEach((v,k) => v.classList.remove('active'))

        // buttons.forEach(function(v, k) {
        //     v.addEventListener('click', function(e) {
        //         let id = v.getAttribute('id')
        //         resetButtons()
        //         resetTables()

        //         v.classList.add('active')

        //         document.getElementById(`table-${id}`).classList.add('active')
        //     })
        // })
    </script>

    <script>
        $(document).ready(function() {
            $("body #basic-form").validate();
        });

        $('body').on('click', '#post', function () {
            // alert('coba')
            $('#title').empty()
            $('.content').empty()
            $.ajax({
                url: '/post/1',
                type: 'GET',
                dataType: 'json',
                
                success: function (data) {
                    console.log('data')
                    $('#title').empty()
                    $('.content').empty()
                    $('#title').append('Berita')
                    $('.content').append(data)
                }
            })
        })

        $('body').on('click', '#pelatihan', function () {
            // alert('coba')
            $('#title').empty()
            $('.content').empty()
            $.ajax({
                url: '/post/2',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log('data')
                    $('#title').empty()
                    $('.content').empty()
                    $('#title').append('Pelatihan')
                    $('.content').append(data)
                }
            })
        })

        $('body').on('click', '#product', function () {
            // alert('coba')
            $('#title').empty()
            $('.content').empty()
            $.ajax({
                url: '/product',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log('data')
                    $('#title').empty()
                    $('.content').empty()
                    $('.content').append(data)
                    $('#title').append('Product')
                }
            })
        })
        
        $('body').on('click', '#dashboard', function () {
            // alert('coba')
            $('#title').empty()
            $('.content').empty()
            $.ajax({
                url: '/dashboard',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    $('#title').empty()
                    $('.content').empty()
                    $('.content').append(data)
                    $('#title').append('Dashboard')
                }
            })
        })

        $('body').on('click', '#user', function () {
            // alert('coba')
            $('#title').empty()
            $('.content').empty()
            $.ajax({
                url: '/user',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    $('#title').empty()
                    $('.content').empty()
                    $('.content').append(data)
                    $('#title').append('Users')
                }
            })
        })

        $('body').on('click', '#order', function () {
            // alert('coba')
            $('#title').empty()
            $('.content').empty()
            $.ajax({
                url: '/order',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    $('#title').empty()
                    $('.content').empty()
                    $('.content').append(data)
                    $('#title').append('Orders')
                }
            })
        })


        $(document).ready(function () {
            console.log('coba');
            $.ajax({
                url: '/dashboard',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    $('#title').empty()
                    $('.content').empty()
                    $('.content').append(data)
                    $('#title').append('Dashboard')
                }
            })
        })


    </script>
    @yield('script')
</body>

</html>
