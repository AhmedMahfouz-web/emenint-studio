@extends('layouts.back')

@section('content')
    <div class="transition-all duration-150 container-fluid" id="page_layout">
        <div id="content_layout">

            <div class=" space-y-5">
                <div class="card">
                    <header class=" card-header noborder">
                        <h4 class="card-title">Blogs
                        </h4>

                        <button data-bs-toggle="modal" data-bs-target="#blackModal"
                            class="btn inline-flex justify-center btn-outline-dark capitalize">
                            Add Blog
                        </button>
                    </header>
                    <div class="card-body px-6 pb-6">
                        <div class="overflow-x-auto -mx-6 dashcode-data-table">
                            <span class=" col-span-8  hidden"></span>
                            <span class="  col-span-4 hidden"></span>
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden ">
                                    <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700"
                                        id="data-table">
                                        <thead class=" border-t border-slate-100 dark:border-slate-800">
                                            <tr>

                                                <th scope="col" class=" table-th ">
                                                    Id
                                                </th>

                                                <th scope="col" class=" table-th ">
                                                    Order
                                                </th>

                                                <th scope="col" class=" table-th ">
                                                    Customer
                                                </th>

                                                <th scope="col" class=" table-th ">
                                                    Date
                                                </th>

                                                <th scope="col" class=" table-th ">
                                                    Quantity
                                                </th>

                                                <th scope="col" class=" table-th ">
                                                    Amount
                                                </th>

                                                <th scope="col" class=" table-th ">
                                                    Status
                                                </th>

                                                <th scope="col" class=" table-th ">
                                                    Action
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="table-td">1</td>
                                                <td class="table-td ">#951</td>
                                                <td class="table-td">
                                                    <span class="flex">
                                                        <span class="w-7 h-7 rounded-full ltr:mr-3 rtl:ml-3 flex-none">
                                                            <img src="assets/images/all-img/customer_1.png" alt="1"
                                                                class="object-cover w-full h-full rounded-full">
                                                        </span>
                                                        <span
                                                            class="text-sm text-slate-600 dark:text-slate-300 capitalize">Jenny
                                                            Wilson</span>
                                                    </span>
                                                </td>
                                                <td class="table-td ">3/26/2022</td>
                                                <td class="table-td ">
                                                    <div>
                                                        13
                                                    </div>
                                                </td>
                                                <td class="table-td ">
                                                    <div>
                                                        $1779.53
                                                    </div>
                                                </td>
                                                <td class="table-td ">

                                                    <div
                                                        class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25 text-success-500
                              bg-success-500">
                                                        paid
                                                    </div>

                                                </td>
                                                <td class="table-td ">
                                                    <div>
                                                        <div class="relative">
                                                            <div class="dropdown relative">
                                                                <button class="text-xl text-center block w-full "
                                                                    type="button" id="tableDropdownMenuButton1"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <iconify-icon
                                                                        icon="heroicons-outline:dots-vertical"></iconify-icon>
                                                                </button>
                                                                <ul
                                                                    class=" dropdown-menu min-w-[120px] absolute text-sm text-slate-700 dark:text-white hidden bg-white dark:bg-slate-700
                                  shadow z-[2] float-left overflow-hidden list-none text-left rounded-lg mt-1 m-0 bg-clip-padding border-none">
                                                                    <li>
                                                                        <a href="#"
                                                                            class="text-slate-600 dark:text-white block font-Inter font-normal px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600
                                      dark:hover:text-white">
                                                                            View</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#"
                                                                            class="text-slate-600 dark:text-white block font-Inter font-normal px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600
                                      dark:hover:text-white">
                                                                            Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#"
                                                                            class="text-slate-600 dark:text-white block font-Inter font-normal px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600
                                      dark:hover:text-white">
                                                                            Delete</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
        id="blackModal" tabindex="-1" aria-labelledby="blackModalLabel" aria-hidden="true">
        <div class="modal-dialog relative w-auto pointer-events-none">
            <div
                class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding
                                            rounded-md outline-none text-current">
                <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-5 border-b rounded-t dark:border-slate-600 bg-black-500">
                        <h3 class="text-base font-medium text-white dark:text-white capitalize">
                            Add New Blog
                        </h3>
                        <button type="button"
                            class="text-slate-400 bg-transparent hover:text-slate-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center
                                                        dark:hover:bg-slate-600 dark:hover:text-white"
                            data-bs-dismiss="modal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="#ffffff" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form action="{{ Route('add blog') }}" enctype="multipart/form-data" method="POST">
                        <div class="p-6 space-y-4">
                            @csrf
                            <div class="input-area">
                                <label for="title" class="form-label">Title</label>
                                <input id="title" name="title" type="text" class="form-control"
                                    placeholder="Title">
                            </div>
                            <div class="input-area">
                                <div class="filegroup">
                                    <label>
                                        <label for="image">Image :</label>
                                        <input type="file" class=" w-full hidden" id="image" name="image">
                                        <span class="w-full h-[40px] file-control flex items-center custom-class">
                                            <span class="flex-1 overflow-hidden text-ellipsis whitespace-nowrap">
                                                <span class="text-slate-400">Choose a file or drop it here...</span>
                                            </span>
                                            <span
                                                class="file-name flex-none cursor-pointer border-l px-4 border-slate-200 dark:border-slate-700 h-full inline-flex items-center bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 text-sm rounded-tr rounded-br font-normal">Browse</span>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <textarea id="default">Hello my friends! today i'm gonna talk about...</textarea>
                        </div>
                        <!-- Modal footer -->
                        <div
                            class="flex items-center p-6 space-x-2 border-t justify-end border-slate-200 rounded-b dark:border-slate-600">

                            <button data-bs-dismiss="modal" type="button"
                                class="btn inline-flex justify-self-end btn-secondary"
                                style="cursor: pointer">Cancel</button>
                            <button type="submit" class="btn inline-flex justify-self-end text-white btn-primary"
                                style="cursor: pointer">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        // window.onload = () => {
        //     let editor = document.getElementsByClassName('ql-editor')[0];
        //     let textarea = document.getElementById('textarea');
        //     console.log(editor.getElementsByTagName('p')[0]);
        //     editor.getElementsByTagName('p')[0].onchange = () => {
        //         console.log(editor.getElementsByTagName('p')[0].value);
        //         textarea.innerHTML = editor.getElementsByTagName('p')[0].value
        //     }
        // }
        tinymce.init({
            selector: 'textarea#default', // change this value according to your HTML
            plugins: 'a_tinymce_plugin',
            a_plugin_option: true,
            a_configuration_option: 400
        });
    </script>
@endsection
