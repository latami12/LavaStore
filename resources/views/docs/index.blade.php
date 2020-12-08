<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Documentation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        body {
            background-color: #f2f2f2;
        }

        .tabs .tab a {
            color: rgb(75, 75, 75);
        }

        /*Black color to the text*/

        .tabs .tab a:hover {
            background-color: #eee;
            color: rgb(75, 75, 75);
        }

        /*Text color on hover*/

        .tabs .tab a.active {
            background-color: #eee;
            color: rgb(75, 75, 75);
        }

        /*Background and text color when a tab is active*/

        .tabs .indicator {
            background-color: rgb(75, 75, 75);
        }

        /*Color of underline*/

        .container {
            width: 80%;
            max-width: initial;
        }

        .container>.row {
            margin: 0;
        }

        .container>.row>.col {
            padding: 0;
        }

        h3 {
            font-family: 'Times New Roman', Times, sens-serif;
        }

    </style>
</head>
@extends('main')

@section('title')
    <title>Dashboard</title>
@endsection

@section('content')
<body>

    <div class="container mt-3">

        <h3 class="center mb-3">
            Lava<i class="fa fa-opencart"></i>Store
        </h3>

        <ul id="tabs-swipe-demo" class="tabs">
            <li class="tab col s3">
                <a class="active" href="#user">user</a>
            </li>
            <li class="tab col s3">
                <a href="#shop">shop</a>
            </li>
            <li class="tab col s3">
                <a href="#cart">order</a>
            </li>
            <li class="tab col s3">
                <a href="#transaction">transaction</a>
            </li>
            <li class="tab col s3">
                <a href="#payment">payment</a>
            </li>
            <li class="tab col s3">
                <a href="#account">account</a>
            </li>
            <li class="tab col s3">
                <a href="#chat">chat</a>
            </li>
            <li class="tab col s3">
                <a href="#others">others</a>
            </li>
        </ul>

        <div class="card">
            <div class="card-content">

                <div id="user" class="col s12">
                    {{-- <span class="card-title">
                        <h5 class="center">User</h5>
                    </span> --}}
                    <table class="highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Endpoint</th>
                                <th>Method</th>
                                <th>Data</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>/login</td>
                                <td>POST</td>
                                <td>email, password</td>
                                <td>-</td>
                            </tr>

                            <tr>
                                <td>/register</td>
                                <td>POST</td>
                                <td>name, email, password, password_confirmation</td>
                                <td>-</td>
                            </tr>

                            <tr>
                                <td>/logout</td>
                                <td>GET</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>

                            

                        </tbody>
                    </table>
                </div>

                <div id="shop" class="col s12">
                    <table class="highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Endpoint</th>
                                <th>Method</th>
                                <th>Data</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>product</td>
                                <td>GET</td>
                                <td></td>
                                <td>Menampilkan semua barang yang dijual</td>
                            </tr>

                            <tr>
                                <td>/product</td>
                                <td>POST</td>
                                <td>name, description, image, price, weight, status, category_id</td>
                                <td>Membuat barang</td>
                            </tr>

                            <tr>
                                <td>/product</td>
                                <td>PATCH</td>
                                <td>name, description, image, price, weight, status</td>
                                <td>MengUpdate barang</td>
                            </tr>

                            <tr>
                                <td>/product/{id}</td>
                                <td>DELETE</td>
                                <td>-</td>
                                <td>Menghapus product</td>
                            </tr>

                            <tr>
                                <td>/product/search</td>
                                <td>POST</td>
                                <td></td>
                                <td>Mencari Product</td>
                            </tr>

                            <tr>
                                <td>/product/seller</td>
                                <td>GET</td>
                                <td>-</td>
                                <td>Mengambil barang sang penjual</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                {{-- <div id="product" class="col s12">
                    <table class="highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Endpoint</th>
                                <th>Method</th>
                                <th>Data</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>/product</td>
                                <td>GET</td>
                                <td>-</td>
                                <td>Mengambil semua data produk</td>
                            </tr>

                            <tr>
                                <td>/product/{id}</td>
                                <td>GET</td>
                                <td>-</td>
                                <td>Mengambil data produk berdasar id produk</td>
                            </tr>

                            <tr>
                                <td>/product</td>
                                <td>POST</td>
                                <td>product_name, description, price, stock, image(optional), category_id, shop_id</td>
                                <td>Menambahkan produk</td>
                            </tr>

                            <tr>
                                <td>/product/{id}</td>
                                <td>PATCH</td>
                                <td>product_name, description, price, stock, image(optional), category_id</td>
                                <td>Mengubah produk</td>
                            </tr>

                            <tr>
                                <td>/product/{id}</td>
                                <td>DELETE</td>
                                <td>-</td>
                                <td>Menghapus produk</td>
                            </tr>

                            <tr>
                                <td>/product/category/{category_id}</td>
                                <td>GET</td>
                                <td>-</td>
                                <td>Mencari Produk berdasarkan kategori</td>
                            </tr>
                        </tbody>
                    </table>
                </div> --}}

                <div id="cart" class="col s12">
                    <table class="highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Endpoint</th>
                                <th>Method</th>
                                <th>Data</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>/order/{id}</td>
                                <td>POST</td>
                                <td>jumlah_barang, produk_id, customer_id(hidden), tanggal(hidden), status(hidden), harga(hidden)</td>
                                <td>Memesan barang kekaranjang</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div id="transaction" class="col s12">
                    <table class="highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Endpoint</th>
                                <th>Method</th>
                                <th>Data</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>/checkout</td>
                                <td>GET</td>
                                <td>order, order_detail</td>
                                <td>Checkout barang</td>
                            </tr>

                            <tr>
                                <td>/checkout/{id}</td>
                                <td>DELETE</td>
                                <td></td>
                                <td>Menghapus barang dari keranjang</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div id="payment" class="col s12">
                    <table class="highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Endpoint</th>
                                <th>Method</th>
                                <th>Data</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>/konfirmasi</td>
                                <td>POST</td>
                                <td>customer_id, order_id</td>
                                <td>Konfirmasu barang yang dibeli</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="account" class="col s12">
                    <table class="highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Endpoint</th>
                                <th>Method</th>
                                <th>Data</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>/profile</td>
                                <td>GET</td>
                                <td>-</td>
                                <td>Menampilkan Semua User</td>
                            </tr>

                            <tr>
                                <td>/profile/{id}</td>
                                <td>PATCH</td>
                                <td>nomor_telepon, alamat, umur</td>
                                <td>Mengupdate 'detail' user berdasarkan id</td>
                            </tr>


                            <tr>
                                <td>/profile/{id}</td>
                                <td>DELETE</td>
                                <td>user_id, password</td>
                                <td>Menghapus user berdasarkan id</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div id="chat" class="col s12">
                    <table class="highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Endpoint</th>
                                <th>Method</th>
                                <th>Data</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>/user/{user_id}/chat</td>
                                <td>GET</td>
                                <td>-</td>
                                <td>Mengambil list yang pernah chat</td>
                            </tr>

                            <tr>
                                <td>/chat/user/{user_id}</td>
                                <td>POST</td>
                                <td>from</td>
                                <td>Mengambil chat dari user yang login dan satunya</td>
                            </tr>

                            <tr>
                                <td>/chat/send/{user_id}</td>
                                <td>POST</td>
                                <td>to, chat</td>
                                <td>Mengirim chat</td>
                            </tr>

                            <tr>
                                <td>/chat/{chat_id}</td>
                                <td>DELETE</td>
                                <td>-</td>
                                <td>Menghapus chat berdasarkan id</td>
                            </tr>

                            <tr>
                                <td>/chat/user</td>
                                <td>POST</td>
                                <td>from, to</td>
                                <td>Menghapus semua chat user yang dipilih</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="others" class="col s12">
                    <table class="highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Endpoint</th>
                                <th>Method</th>
                                <th>Data</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>/product/search</td>
                                <td>POST</td>
                                <td>keyword</td>
                                <td>Memcari barang</td>
                            </tr>
                            <tr>
                                <td>/profile/search</td>
                                <td>POST</td>
                                <td>keyword</td>
                                <td>Memcari profile</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.tabs').tabs();
        });

    </script>
</body>

</html>
@endsection