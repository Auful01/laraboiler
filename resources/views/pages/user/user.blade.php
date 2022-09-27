
   <div class="card shadow mt-3 border-0" data-aos="fade-up">
        <div class="card-body">
            <div class="table-responsive">
                <table id="posts-table" class="table table-striped">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Foto</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        {{-- <tr id="posts-body">

                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modal-detail-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content ">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img src="" class="img-fluid text-center" id="foto" style="height: 200px; clip-path: circle()" alt="">
                </div>
              <div class="form-group my-2 d-flex">
                <div class="col-md-3">
                  <label for="">Nama</label>
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control form-control-sm" id="nama" name="nama" readonly>
                </div>
              </div>
                <div class="form-group my-2 d-flex">
                    <div class="col-md-3">
                    <label for="">Email</label>
                    </div>
                    <div class="col-md-9">
                    <input type="text" class="form-control form-control-sm" id="email" name="email" readonly>
                    </div>
                </div>
                <div class="form-group my-2 d-flex">
                    <div class="col-md-3">
                    <label for="">Alamat</label>
                    </div>
                    <div class="col-md-9">
                    <input type="text" class="form-control form-control-sm" id="alamat" name="alamat" readonly>
                    </div>
                </div>
                <div class="form-group my-2 d-flex">
                    <div class="col-md-3">
                    <label for="">Role</label>
                    </div>
                    <div class="col-md-9">
                    <input type="text" class="form-control form-control-sm" id="role" name="role" readonly>
                    </div>
                </div>
                <div class="form-group d-flex">
                    <div class="col-md-3">
                    <label for="">Status</label>
                    </div>
                    <div class="col-md-9">
                    <input type="text" class="form-control form-control-sm" id="status" name="status" readonly>
                    </div>
                </div>

                <div class="form-group d-flex mt-3">
                    <div class="col-md-3">
                        <label for="">Foto Ktp</label>
                    </div>
                    <div class="col-md-9">
                        <img src="" class="img-fluid text-center" id="foto-ktp" style="height: 200px" alt="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    <script>
        // $(document).ready(function () {

        //     $.ajax({
        //        url: '/api/users/',
        //        type: 'GET',
        //        dataType: 'json',
        //        headers: {
        //            'Authorization': 'Bearer {{Auth::user()->remember_token}}'
        //        },
        //        success: function (data) {
        //         console.log(data);
        //            $('body #posts-table').DataTable({
        //                data: data.user,
        //                columns: [
        //                    { data: 'id' },
        //                    { data: 'nama' },
        //                    { data: 'foto' ,
        //                          render: function (data, type, row, meta) {
        //                               return `<a target="_blank" href="{{asset('storage/user/`+data+`')}}"><img src="{{asset('storage/user/`+data+`')}}" class="img-fluid" style="width: 80px" alt=""></a>`; 
        //                          }
        //                     },
        //                    { data: 'email' },
        //                    { data: 'alamat' },
        //                    { data: 'role.role' },
        //                    { data: 'profil.verifikasi',
        //                          render: function (data, type, row) {
        //                             if (row.role.role == 'umkm') {
        //                                 if (data == 1) {
        //                                   return '<span class="badge alert-success">Verified</span>';
        //                                 } else {
        //                                   return '<span class="badge alert-danger">Not Verified</span>';
        //                                 }
        //                             } else {
        //                                 return '-';
        //                             }
                                        
        //                             },
        //                             name: 'profil.verifikasi'
                                 
        //                     },
        //                    { data: 'id',
        //                        render: function (data, type, row) {
        //                            if (row.role.role == 'umkm') {
        //                             //    var coba;
                            
        //                             // console.log(!row.profil.verifikasi );
        //                             return '<button type="button" '+ row.profil.verifikasi +' '+ (row.profil.verifikasi == 1 ? 'disabled' : '') +' class="btn btn-success btn-sm shadow btn-verif-user" data-id="'+ data +'" style="border-radius:8px"><i class="fas fa-check" style="color:white"></i></button> <button type="button" class="btn btn-info btn-sm shadow btn-detail-user" data-id="'+ data +'" style="border-radius:8px"><i class="fas fa-eye" style="color:white"></i></button> <button class="btn btn-danger btn-sm shadow" style="border-radius:8px"><i class="fas fa-eraser"></i></button>'
        //                         }else{
        //                             return '<button type="button" class="btn btn-info btn-sm shadow btn-detail-user" data-id="'+ data +'" style="border-radius:8px"><i class="fas fa-eye" style="color:white"></i></button> <button class="btn btn-danger btn-sm shadow" style="border-radius:8px"><i class="fas fa-eraser"></i></button>'

        //                         }
        //                        }
        //                    },
        //                ]
        //            })
        //        }
        //    })

        // })
           $('body #posts-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/api/users/',
                    headers: {
                        'Authorization': 'Bearer {{Auth::user()->remember_token}}'
                    },
                    dataSrc: data.data
                },
                columns: [
                     { data: 'id' },
                     { data: 'nama' },
                     { data: 'profil.foto' ,
                             render: function (data, type, row, meta) {
                             return `<a target="_blank" href="{{asset('storage/user/`+data+`')}}"><img src="{{asset('storage/user/`+data+`')}}" class="img-fluid" style="width: 80px" alt=""></a>`; 
                             }
                      },
                     { data: 'email' },
                     { data: 'profil.alamat' },
                     { data: 'role.role' },
                     { data: 'profil.verifikasi',
                             render: function (data, type, row) {
                             if (row.role.role == 'umkm') {
                                  if (data == 1) {
                                     return '<span class="badge alert-success">Verified</span>';
                                  } else {
                                     return '<span class="badge alert-danger">Not Verified</span>';
                                  }
                             } else {
                                  return '-';
                             }
                                  
                             },
                             name: 'profil.verifikasi'
                             
                      },
                      { data: 'id',
                               render: function (data, type, row) {
                                console.log(row.profil);
                                   if (row.role.role == 'umkm') {
                                    //    var coba;
                            
                                    // console.log(!row.profil.verifikasi );
                                    return '<button type="button" '+ row.profil.verifikasi +' '+ (row.profil.verifikasi == 1 ? 'disabled' : '') +' class="btn btn-success btn-sm shadow btn-verif-user" data-id="'+ data +'" style="border-radius:8px"><i class="fas fa-check" style="color:white"></i></button> <button type="button" class="btn btn-info btn-sm shadow btn-detail-user" data-id="'+ data +'" style="border-radius:8px"><i class="fas fa-eye" style="color:white"></i></button> <button class="btn btn-danger btn-sm shadow" style="border-radius:8px"><i class="fas fa-eraser"></i></button>'
                                }else{
                                    return '<button type="button" class="btn btn-info btn-sm shadow btn-detail-user" data-id="'+ data +'" style="border-radius:8px"><i class="fas fa-eye" style="color:white"></i></button> <button class="btn btn-danger btn-sm shadow" style="border-radius:8px"><i class="fas fa-eraser"></i></button>'

                                }
                               }
                           },
                        ]
                            
           })

       $('body').on('click', '.btn-detail-user', function () {
           var id = $(this).data('id');
           $.ajax({
               url: '/api/users/' + id,
               type: 'GET',
               dataType: 'json',
               headers: {
                   'Authorization': 'Bearer {{Auth::user()->remember_token}}'
               },
               success: function (data) {
                   $('#modal-detail-user').modal('show');
                   console.log(data);
                   $('body  #nama').val(data.data.nama);
                   $('body  #email').val(data.data.email);
                   $('body  #alamat').val(data.data.profil?.alamat);
                   $('body  #role').val(data.data.role?.role);
                   $('body  #status').val(data.data.profil?.verifikasi == 1 ? 'Verified' : 'Not Verified');
                   $('body  #foto').attr('src', "{{asset('storage/posts/aku.png')}}" );
                   $('body  #foto-ktp').attr('src', "{{asset('storage/posts/aku.png')}}" );
               }
           })
       })


       $('body').on('click', '.btn-verif-user', function () {
           var id = $(this).data('id');
           Swal.fire({
               title: 'Are you sure?',
               text: "You won't be able to revert this!",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Yes, verify it!'
           }).then((result) => {
               if (result.value) {
                   $.ajax({
                       url: '/api/verif-user',
                       type: 'POST',
                       data : {
                           id: id
                       },
                       dataType: 'json',
                       headers: {
                           'Authorization': 'Bearer {{Auth::user()->remember_token}}'
                       },
                       beforeSend: function () {
                           Swal.fire({
                               title: 'Please Wait',
                               text: 'Verifying User',
                               loading: true,
                               showConfirmButton: false,
                               timerProgressBar: true,
                               allowOutsideClick: false
                           })
                       },
                       success: function (data) {
                           Swal.fire({
                               title: 'Verified!',
                               text: 'Your file has been verified.',
                               icon: 'success',
                               timer: 2000,
                                 showConfirmButton: false,
                                 timerProgressBar: true,
                           }

                           )
                       }
                   })
               }
           })
        //    $.ajax({
        //        url: '/api/users/'+id+'/verifikasi',
        //        type: 'PUT',
        //        dataType: 'json',
        //        headers: {
        //            'Authorization': 'Bearer {{Auth::user()->remember_token}}'
        //        },
        //        success: function (data) {
        //            console.log(data);
        //            $('body #posts-table').DataTable().ajax.reload();
        //        }
        //    })
       })
   </script>