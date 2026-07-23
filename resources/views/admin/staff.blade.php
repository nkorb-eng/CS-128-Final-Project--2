<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - Staff Management</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://unpkg.com/lucide@latest"></script>

</head>


<body class="bg-gray-100 min-h-screen">


    <div class="max-w-7xl mx-auto px-6 py-10">


        <!-- Header -->

        <div class="flex items-center justify-between mb-8">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Staff Management
                </h1>

                <p class="text-gray-500 mt-1">
                    Manage hotel employees and their positions
                </p>

            </div>


            <div class="bg-blue-600 text-white p-3 rounded-xl shadow">

                <i data-lucide="users"></i>

            </div>


        </div>



        <!-- Add Button -->

        <div class="flex justify-end mb-8">


            <button type="button" onclick="openStaffModal()" class="bg-blue-600 hover:bg-blue-700 
            text-white px-5 py-3 rounded-xl 
            flex items-center gap-2 shadow">


                <i data-lucide="user-plus" class="w-5"></i>

                Add Staff


            </button>


        </div>





        <!-- Modal -->

        <div id="staffModal" class="hidden fixed inset-0 bg-black/50 
        flex items-center justify-center z-50">


            <div class="bg-white w-full max-w-md 
            rounded-2xl shadow-xl p-6">


                <!-- Modal Header -->


                <div class="flex justify-between items-center mb-6">


                    <h2 class="text-xl font-bold flex items-center gap-2">


                        <i data-lucide="user-plus"></i>

                        Add New Staff


                    </h2>



                    <button type="button" onclick="closeStaffModal()" class="text-gray-500 hover:text-red-500">


                        <i data-lucide="x"></i>


                    </button>


                </div>




                <!-- FORM -->

                <form action="{{ route('admin.staff.store') }}" method="POST">


                    @csrf



                    <!-- Name -->


                    <div class="mb-4">


                        <label class="block text-sm font-medium mb-2">

                            Staff Name

                        </label>



                        <input type="text" name="staffname" required placeholder="Enter staff name" class="w-full px-4 py-3 rounded-xl border
                        focus:ring-2 focus:ring-blue-500 outline-none">


                    </div>





                    <!-- Work -->


                    <div class="mb-6">


                        <label class="block text-sm font-medium mb-2">

                            Position

                        </label>



                        <select name="staffwork" required class="w-full px-4 py-3 rounded-xl border
                        focus:ring-2 focus:ring-blue-500 outline-none">


                            <option value="">
                                Select Position
                            </option>

                            <option value="Manager">
                                Manager
                            </option>

                            <option value="Cook">
                                Cook
                            </option>

                            <option value="Helper">
                                Helper
                            </option>

                            <option value="Cleaner">
                                Cleaner
                            </option>

                            <option value="Waiter">
                                Waiter
                            </option>


                        </select>


                    </div>





                    <!-- Buttons -->


                    <div class="flex gap-3">


                        <button type="button" onclick="closeStaffModal()" class="flex-1 bg-gray-200 
                        hover:bg-gray-300 py-3 rounded-xl">


                            Cancel


                        </button>




                        <button type="submit" class="flex-1 bg-blue-600 
                        hover:bg-blue-700 text-white
                        py-3 rounded-xl flex 
                        justify-center items-center gap-2">


                            <i data-lucide="save"></i>

                            Save


                        </button>



                    </div>



                </form>



            </div>


        </div>





        <!-- Staff Cards -->


        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">


            @foreach ($staff as $row)


                <div class="bg-white rounded-2xl shadow-md p-6
                hover:shadow-xl transition">


                    <div class="flex justify-center mb-5">


                        <div class="bg-blue-100 text-blue-600
                        p-5 rounded-full">


                            <i data-lucide="user-round" class="w-10 h-10"></i>


                        </div>


                    </div>



                    <div class="text-center">


                        <h3 class="text-xl font-bold text-gray-800">

                            {{ $row->name }}

                        </h3>



                        <p class="text-gray-500 mt-1">

                            {{ $row->work }}

                        </p>



                        <span class="inline-block mt-3 px-3 py-1
                        bg-green-100 text-green-700
                        text-sm rounded-full">

                            Active

                        </span>


                    </div>




                    <div class="mt-5">


                        <a href="{{ route('admin.staff.delete', $row->id) }}" onclick="return confirm('Delete this staff?')">


                            <button class="w-full bg-red-500 hover:bg-red-600
                            text-white py-2 rounded-xl flex
                            justify-center items-center gap-2">


                                <i data-lucide="trash-2"></i>

                                Delete


                            </button>


                        </a>


                    </div>


                </div>



            @endforeach


        </div>



    </div>





    <script>


        function openStaffModal() {

            document
                .getElementById('staffModal')
                .classList
                .remove('hidden');

        }



        function closeStaffModal() {

            document
                .getElementById('staffModal')
                .classList
                .add('hidden');

        }



        lucide.createIcons();


    </script>



</body>

</html>