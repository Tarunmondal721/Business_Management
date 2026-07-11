   <!-- ========== Buyer User Table ========== -->
   <div class="row mt-30">
       <div class="col-lg-12">
           <div class="card shadow-sm border-0 rounded">

               <div class="card-header bg-primary  d-flex justify-content-between align-items-center">
                   <h5 class="mb-0 text-white">All Fish</h5>
                   <a href="{{ route('admin.fish.create') }}" class="btn btn-light btn-sm">
                       <i class="bi bi-plus-circle"></i> Add New Fish
                   </a>
               </div>



               <div class="card-body">
                   <div class="card-body">
                       <div class="table-responsive">
                           <table class ="table table-hover table-striped table-bordered text-center align-middle"
                               id="FishTable">
                               <thead>
                                   <tr>
                                       <th scope="col" class="text-center">#</th>
                                       <th scope="col" class="text-center">Fish Name</th>
                                       <th scope="col" class="text-center">Image</th>
                                       <th scope="col" class="text-center">Actions</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @foreach ($allfish as $index => $fish)
                                       <tr>
                                           <th scope="row" class="text-center">{{ $index + 1 }}</th>
                                           <td class="text-center">{{ $fish->name }}</td>
                                           <td>
                                               <img src="{{ asset('storage/fish/' . $fish->image) }}" alt="Image"
                                                   class="img-fluid rounded shadow" style="max-width: 100px; max-height: 100px;">
                                           </td>
                                           <td>
                                               {{-- <button class="btn btn-outline-info btn-sm viewRoleBtn"
                                                            data-id="{{ $buyerUser->id }}" data-name="{{ $buyerUser->name }}" title="View Permissions">
                                                            <i class="fa-solid fa-eye" ></i>
                                                        </button> --}}
                                               <a href="{{ route('admin.fish.edit', $fish->id) }}"
                                                   class="btn btn-outline-warning btn-sm" title="Edit Fish">
                                                   <i class="fa-solid fa-pencil"></i>
                                               </a>
                                               <button data-id="{{ $fish->id }}"
                                                   class="btn btn-sm btn-outline-danger deleteBtn"
                                                   title="Delete Fish">
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

                       </div>
                   </div>
               </div>

           </div>
       </div>
   </div>
