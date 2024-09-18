<style>
    p {
        font-family: 'Poppins', sans-serif;
        font-size: 1.1em;
        font-weight: 300;
        line-height: 1.7em;
        color: #999;
    }

    a,
    a:hover,
    a:focus {
        color: inherit;
        text-decoration: none;
        transition: all 0.3s;
    }



    .line {
        width: 100%;
        height: 1px;
        border-bottom: 1px dashed #ddd;
        margin: 40px 0;
    }

    /* ---------------------------------------------------
    SIDEBAR STYLE
----------------------------------------------------- */

    .wrapper {
        display: flex;
        width: 100%;
        align-items: stretch;
    }

    #sidebar {
        max-height: 110vh;
        overflow-y: auto;
        min-width: 250px;
        max-width: 250px;
        background: #7386D5;
        color: #fff;
        transition: all 0.3s;
    }

    #sidebar.active {
        margin-left: -250px;
    }

    #sidebar .sidebar-header {
        padding: 20px;
        background: #6d7fcc;
    }


    #sidebar ul p {
        color: #fff;
        padding: 10px 15px;
    }

    #sidebar ul li a {
        padding: 10px 15px;
        font-size: 1.1em;
        display: block;
    }

    #sidebar ul li a:hover {
        color: #7386D5;
        background: #fff;
    }

    #sidebar ul li .logout:hover {
        color: #fff;
        background: #dc3545;
    }

    #sidebar ul li.onthis,
    ul a.onthis {
        color: #fff;
        background: #464646;
    }

    #sidebar ul>a.onthis {
        color: #fff;
        background: #464646;
    }


    #sidebar ul li.active>a,
    a[aria-expanded="true"] {
        color: #fff;
        background: #6d7fcc;
    }

    a[data-bs-toggle="collapse"] {
        position: relative;
    }

    .dropdown-toggle::after {
        display: block;
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
    }

    #sidebar>ul ul a {
        font-size: 0.9em !important;
        padding-left: 30px !important;
        background: #6d7fcc;
    }

    /* ---------------------------------------------------
    CONTENT STYLE
----------------------------------------------------- */

    #content {
        width: 100%;
        padding: 20px;
        min-height: 100vh;
        transition: all 0.3s;
    }

    /* ---------------------------------------------------
    MEDIAQUERIES
----------------------------------------------------- */

    .dataTables_scrollHeadInner {
        width: 100% !important;
    }

    table.table.table-sm.table-bordered.border-dark.table-responsive-sm.table-hover.dataTable.no-footer {
        width: 100% !important;
    }

    @media (max-width: 768px) {
        #sidebar {
            margin-left: -250px;
            position: fixed;
            height: 100%;
            z-index: 1;
        }

        .navbar {
            position: fixed;
            overflow: hidden;
            top: 0;
            width: 100%;
        }

        .main {
            margin-top: 60px;
        }

        #sidebarCollapse1 {
            display: none;
        }

        #sidebar.active {
            /* min-width: 100%; */
            margin-left: 0;
        }

        #sidebarCollapse span {
            display: none;
        }

        .row-1 {
            margin-bottom: 20px;
            width: 100%;
        }


        .header_transaksi {
            display: flex;
            justify-content: space-between;
            flex-direction: column;
        }

        .row-header {
            display: flex;
            justify-content: unset;
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<!-- Sidebar  -->
<nav id="sidebar" class="shadow-sm">
    <div class="sidebar-header text-center">
        Trustme Konveksi
    </div>
    <div class="name-app px-2">
        <hr>
        <p class="text-center text-light">Operational App</p>
        <hr>
    </div>
    <ul class="list-unstyled components">
        <li class="@if ($menu == 'Dashboard')onthis @endif">
            <a href="{{url('dashboard')}}" class=""><i class="bi bi-speedometer me-2"></i>Dashboard</a>
        </li>
        <li class="@if ($menu == 'Orders')onthis @endif">
            <a href="{{url('orders')}}" class=""><i class="bi bi-bag-plus me-2"></i>Order<span class="badge text-bg-warning ms-1">{{session()->get('badge.order');}}</span></a>
        </li>
        <li class="">
            <a href="#potonganbahan" data-bs-toggle="collapse" aria-expanded="@if ($menu == 'PotonganBahan')true @else false @endif" class="@if ($menu == 'PotonganBahan') dropdown-toggle @else dropdown-toggle collapsed @endif"><i class="bi bi-sticky-fill me-2"></i>Potongan Bahan
                @if (session()->get('badge.potongan_bahan') > 0)
                <span class="badge text-bg-warning ms-1">
                    {{session()->get('badge.potongan_bahan');}}
                </span>
                @endif
            </a>
            <ul class="@if ($menu == 'PotonganBahan') collapsed @else collapse @endif list-unstyled" id="potonganbahan">
                <a class="@if ( isset($submenu) and $submenu == 'inputdatapotonganbahan')onthis @endif" href="{{ url('potonganbahan') }}">Input Data
                    @if (session()->get('badge.potongan_bahan') > 0)
                    <span class="badge text-bg-warning ms-1">
                        {{session()->get('badge.potongan_bahan');}}
                    </span>
                    @endif</a>
                <a class="@if ( isset($submenu) and $submenu == 'historypotonganbahan')onthis @endif" href="{{ url('historypotonganbahan') }}">History</a>
                <!-- <a href="#">History </a> -->
            </ul>
        </li>
        <li class="">
            <a href="#potonganbahandetail" data-bs-toggle="collapse" aria-expanded="@if ($menu == 'PotonganBahanDetail')true @else false @endif" class="@if ($menu == 'PotonganBahanDetail') dropdown-toggle @else dropdown-toggle collapsed @endif"><i class="bi bi-sticky-fill me-2"></i>Potongan Bahan Detail
            </a>
            <ul class="@if ($menu == 'PotonganBahanDetail') collapsed @else collapse @endif list-unstyled" id="potonganbahandetail">
                <a class="@if ( isset($submenu) and $submenu == 'inputdatapotonganbahandetail')onthis @endif" href="{{ url('potonganbahandetail') }}">Input Data Process </a>
                <a class="@if ( isset($submenu) and $submenu == 'inputdatapotonganbahandetail')onthis @endif" href="{{ url('potonganbahandetail') }}">Input Data Closed </a>
                <a class="@if ( isset($submenu) and $submenu == 'inputdatapotonganbahandetail')onthis @endif" href="{{ url('potonganbahandetail') }}">History </a>
                    <!-- <a href="#">History </a> -->
            </ul>
        </li>
        <li class="@if ($menu == 'Customer')onthis @endif">
            <a href="{{url('customer')}}" class=""><i class="bi bi-person-vcard me-2"></i>Customer</a>
        </li>
        <li class="@if ($menu == 'Modelpola')onthis @endif">
            <a href="{{url('Model_pola')}}" class=""><i class="bi bi-diamond-half me-2"></i>Model/Pola</a>
        </li>
        <li class="@if ($menu == 'Karyawan')onthis @endif">
            <a href="{{url('karyawan')}}" class=""><i class="bi bi-people me-2"></i>Karyawan</a>
        </li>
        <li class="@if ($menu == '')onthis @endif">
            <a href="{{url('')}}" class=""><i class="bi bi-key me-2"></i>User</a>
        </li>
        <li class="@if ($menu == '')onthis @endif">
            <a href="{{url('')}}" class=""><i class="bi bi-building-gear me-2"></i>Company Profile</a>
        </li>
        <!-- <li class="">
            <a href="#transaksi" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="bi bi-sticky-fill me-2"></i>Potongan Bahan</a>
            <ul class="collapse list-unstyled" id="transaksi">
                <a href="#">Input Data</a>
                <a href="#">History </a>
            </ul>
        </li> -->
        <li>
            <a class="logout" data-bs-toggle="modal" data-bs-target="#modal_logout" style="cursor:pointer;"><i class="bi bi-box-arrow-left me-2"></i>Log Out </a>
        </li>
    </ul>
    <div class="modal fade" id="modal_logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-dark">
                    Apakah anda yakin akan Log Out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="{{ url('logout')}}" class="btn btn-primary">Yakin</a>
                </div>
            </div>
        </div>
    </div>
</nav>
<script>
    $(document).ready(function() {
        $('.sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });
</script>