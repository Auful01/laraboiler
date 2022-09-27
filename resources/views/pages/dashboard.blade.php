<style>
    .card-dashboard {
        border-radius: 8px; 
        border-right: none;
        border-bottom : none;
        border-top: none; 
        color : #fff;
    }

    .icon-trans{
        opacity : 0.4;
    }
</style>
<div class="row d-flex justify-content-start" data-aos="fade-up">
    <div class="col-md-3 mb-3">
        <div class="card h-100 shadow bg-success card-dashboard card-success" >
            <div class="card-body ">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-5 text-left">
                        <h4 class="text-nowrap" style="font: weight 600px;">User</h4>
                        <h5 id="jumlahUser">0</h5>
                    </div>
                    <div class="col-md-3">
                        <i class="fas fa-user fa-3x mt-1 icon-trans"></i>
                        <!-- <div class="row"> -->
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card h-100 shadow card-dashboard card-info bg-info">
            <div class="card-body">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-7 text-left">
                        <h4 class="text-nowrapA" style="font: weight 600px;">Product</h4>
                        <h5 id="totalProduct">0</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                        <i class="fas fa-box-open fa-3x mt-1 icon-trans"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card h-100 shadow card-dashboard card-warning bg-warning" >
            <div class="card-body">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-5 text-left">
                        <h4 class="text-nowrapA" style="font: weight 600px;">Posts</h4>
                        <h5 id="totalPosts">0</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                        <i class="fas fa-paper-plane fa-3x mt-1 icon-trans"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card h-100 shadow card-dashboard card-danger bg-danger" >
            <div class="card-body">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-8 text-left">
                        <h4 class="text-nowrapA" style="font: weight 600px;">Transaction</h4>
                        <h5 id="jmlOrder">0</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                        <i class="fas fa-coins fa-3x mt-1 icon-trans"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class="row">
    <div class="col-md-8 mb-5">
        <div class="card shadow border-0">
            <div class="card-body">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-5">
        <div class="card shadow border-0">
            <div class="card-body">
                <canvas id="dataUser"></canvas>
            </div>
        </div>
    </div>
</div>


<script>
    var labels = []
    $(document).ready(function () {
        $.ajax({
            url: '/api/db-posts',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer {{Auth::user()->remember_token}}'
            },
            success: function(data){
                $('#totalPosts').text(data.length);
            }
        })
    
    
    
        $.ajax({
            url: '/api/order',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer {{Auth::user()->remember_token}}'
            },
            success: function(data){
                $('#jmlOrder').text(data.length);
            }
        
        })
    
        $.ajax({
            url: '/api/product/',
            type: 'GET',
            dataType: 'json',
            headers: {
                'Authorization': 'Bearer {{Auth::user()->remember_token}}'
            },
            success: function (data) {
                // console.log(data)/;
                $('#totalProduct').text(data.length);
            }
        })
    })

    
    labels = [
      'January',
      'February',
      'March',
      'April',
      'May',
      'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];
  
    var jmlProduk = []
    $.ajax({
        url: '/api/dbproduct/',
        type: 'GET',
        dataType: 'json',
        headers: {
            'Authorization': 'Bearer {{Auth::user()->remember_token}}'
        },
        success: function (data) {
            // $('#totalProduct').text(data.length);
            $.each(data, function(k, v){
                    for (let i = 0; i < labels.length; i++) {
                        if(v.bulan-1 != i){
                            if(jmlProduk[i] == 0){
                                jmlProduk[i] = 0;
                            }else{
                                jmlProduk[i] = (jmlProduk[i] == undefined? 0 : jmlProduk[i]);
                            }
                        }else{
                            jmlProduk[i] = parseInt(v.jumlah)  ;
                        }
                    }
            })
               
            console.log(jmlProduk);
            console.log(data);
        }
    })  


    var data = {
      labels: labels,
      datasets: [{
        label: 'Laporan Transaksi Tahun ini',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: jmlProduk,
      }]
    };
    
    
    
    var config = {
        type: 'line',
      data: data,
      options: {}
    };
    // const configPenjualan = {
    //     type: 'bar',
    //     data: data,
    //   options: {}
    // };

    
    </script>
  <script>
      var jumlah=0;
      var role = []
      var count = []
      $.ajax({
          url: '/api/db-user',
          type: 'GET',
          dataType: 'json',
          headers: {
              'Authorization': 'Bearer {{Auth::user()->remember_token}}'
            },
            success : function (data){
                console.log(data);
                for(var i = 0; i < data.length; i++){
                    jumlah += parseInt(data[i].user); 
                    $('#jumlahUser').text(jumlah);
                    role.push(data[i].role)
                    count.push(data[i].user)
            }
            // console.log(count);
            
            var dataUser = {
                labels: role,
                datasets: [{
                    label: 'My First Dataset',
                    data: count,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                    ],
                    hoverOffset: 4
                }]
            }
            var configDataUser = {
                type: 'doughnut',
                data: dataUser,
                options: {}
            };
            
            var myChartUser = new Chart(
                document.getElementById('dataUser'),
                configDataUser
                );
            
            var myChart = new Chart(
                  document.getElementById('myChart'),
                  config
                  );
                  
           
            }
            })
        </script>