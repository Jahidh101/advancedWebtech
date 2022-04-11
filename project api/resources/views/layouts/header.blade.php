<html>
    <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{url('css/divSize.css')}}">
    </head>

    <body>
        @if(!Session::has('username'))
            <div id="header">
            <a href="{{route('loginUser')}}">Login</a>
            <a href="{{route('register')}}">Register</a>

        @endif
        @if(Session::get('userType') == 'admin')
            <a href="{{route('admin.addUserType')}}">AddUserTypes</a>
            <a href="{{route('admin.UserType.list')}}">UserTypeList</a> <br>
            <a href="{{route('admin.addUser.form')}}">AddUser</a>
            <a href="{{route('admin.login.history.all')}}">LoginHistory</a><br>
            <a href="{{route('admin.medicine.blocked.list')}}">MedicineBlockedList</a>
            <a href="{{route('admin.addDelivaryman')}}">AddDelivaryman</a>
            <a href="{{route('admin.delivaryman.list')}}">DelivarymanList</a>



        @endif

        
        @if(Session::has('username'))
            @if(Session::get('userType') == 'patient')
                <a href ="{{route('patient.doctorList')}}">Doctorlist</a>
                <a href ="{{route('patient.myCart')}}">MyCart</a>
                <a href ="{{route('patient.myOrder.list')}}">MyOrderList</a>

            @endif

            @if(Session::get('userType') == 'doctor')
                <a href ="{{route('doctor.patientList')}}">Patientlist</a>
            @endif

            @if(Session::get('userType') == 'seller')
                <a href ="{{route('seller.medicine.add')}}">AddMedicine</a>
                <a href ="{{route('seller.medicineType.add')}}">AddMedicineType</a>
                <a href ="{{route('seller.medicineType.list')}}">MedicineTypeList</a>
                <a href ="{{route('seller.pending.order.list')}}">PendingOrders</a>
                <a href ="{{route('seller.acceptedOrder.list')}}">AcceptedOrderList</a>
                <a href ="{{route('seller.delivaryman.list')}}">DelivarymanList</a>

            @endif

            @if(Session::get('userType') == 'delivaryman')
                <a href ="{{route('delivaryman.acceptedOrder.list')}}">AcceptedOrderList</a>

            @endif
            <a href ="{{route('seller.medicine.list')}}">MedicineList</a>
            <a href="{{route('user.personal.info',['username'=>encrypt(Session::get('username'))])}}">My profile</a>
            <a href="{{route('add.profile.picture')}}">AddProfilePicture</a>
            <a href="{{route('logout')}}">Logout</a>

            </div>
        @endif

        @yield('content')
        @yield('demo0')
    </body>
</html>