<?php
?>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
          integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</head>
<body>
<div class="container">
    @if($errors)
        <div class="alert alert-warning alert-dismissible " role="alert">{{$errors}}</div>
    @endif
    <h3>Add new employee</h3>

    <form action="{{route('save-employee')}}" method="POST">
        {{csrf_field()}}
        <div class="form-group">
            <label for="first_name">Employee first name</label>
            <input type="text" class="form-control" name="first_name">
        </div>
        <div class="form-group">
            <label for="last_name">Employee last name</label>
            <input type="text" class="form-control" name="last_name">
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" class="form-control">
                <option value="M">M</option>
                <option value="F">F</option>
            </select>
        </div>

        <div class="form-group">
            <div class='input-group date'>
                <label for='birth_date'>Birth date</label>
                <input name="birth_date" type='date' class="form-control">
            </div>
        </div>

        <div class="form-group">
            <div class='input-group date'>
                <label for='hire_date'>Hire date</label>
                <input name="hire_date" type='date' class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="department">Department</label>
            <select name="department" class="form-control">
                @foreach($departments as $key => $department)
                    <option value="{{$key}}">{{$department}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <select name="title" class="form-control">
                @foreach($titles as $titles)
                    <option value="{{$titles}}">{{$titles}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="salary">Salary</label>
            <input name="salary" type='number' class="form-control">
        </div>

        <button type="submit" class="btn">Save Employee</button>
    </form>
</div>
</body>
</html>
