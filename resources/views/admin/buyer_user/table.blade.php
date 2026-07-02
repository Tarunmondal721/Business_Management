   <!-- ========== Buyer User Table ========== -->
   <div class="row mt-30">
       <div class="col-lg-12">
           <div class="card shadow-sm border-0 rounded">

               <div class="card-header bg-primary  d-flex justify-content-between align-items-center">
                   <h5 class="mb-0 text-white">All Buyer Users</h5>
                   <a href="{{ route('admin.buyer-user.create') }}" class="btn btn-light btn-sm">
                       <i class="bi bi-plus-circle"></i> Add Buyer User
                   </a>
               </div>

               {{-- <div class="card-body border-bottom">
                   <form action="{{ route('admin.buyer-user.index') }}" method="GET">
                       <div class="row">
                           <div class="col-md-4">
                               <input type="text" name="search" class="form-control"
                                   placeholder="Search Name or Email..." value="{{ request('search') }}">
                           </div>

                           <div class="col-md-2">
                               <button class="btn btn-primary">
                                   <i class="fa fa-search"></i> Search
                               </button>
                           </div>

                           <div class="col-md-2">
                               <a href="{{ route('admin.buyer-user.index') }}" class="btn btn-secondary">
                                   Reset
                               </a>
                           </div>
                       </div>
                   </form>
               </div> --}}

               <div class="card-body">
                   <div class="card-body">
                       <div class="table-responsive">
                           <table class ="table table-hover table-striped table-bordered text-center align-middle"
                               id="buyerUserTable">
                               <thead>
                                   <tr>
                                       <th scope="col" class="text-center">#</th>
                                       <th scope="col" class="text-center">Buyer User Name</th>
                                       <th scope="col" class="text-center">Email</th>
                                       <th scope="col" class="text-center">Actions</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @foreach ($buyerUsers as $index => $buyerUser)
                                       <tr>
                                           <th scope="row">{{ $index + 1 }}</th>
                                           <td>{{ $buyerUser->name }}</td>
                                           <td>{{ $buyerUser->email }}</td>
                                           <td>
                                               {{-- <button class="btn btn-outline-info btn-sm viewRoleBtn"
                                                            data-id="{{ $buyerUser->id }}" data-name="{{ $buyerUser->name }}" title="View Permissions">
                                                            <i class="fa-solid fa-eye" ></i>
                                                        </button> --}}
                                               <a href="{{ route('admin.buyer-user.edit', $buyerUser->id) }}"
                                                   class="btn btn-outline-warning btn-sm" title="Edit Buyer User">
                                                   <i class="fa-solid fa-pencil"></i>
                                               </a>
                                               <button data-id="{{ $buyerUser->id }}"
                                                   class="btn btn-sm btn-outline-danger deleteBtn"
                                                   title="Delete Buyer User">
                                                   <i class="lni lni-trash-can"></i>
                                               </button>
                                           </td>
                                       </tr>
                                   @endforeach
                               </tbody>
                               <form id="deleteForm" method="POST" style="display:none;">
                                   @csrf
                                   @method('DELETE')
                               </form>
                           </table>
                           {{-- <div class="d-flex justify-content-end mt-3">
                               {{ $buyerUsers->links() }}
                           </div> --}}
                       </div>
                   </div>
               </div>

           </div>
       </div>
   </div>
