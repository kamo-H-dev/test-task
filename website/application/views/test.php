<!DOCTYPE html>
<html lang="en">
<head>
    <title>test</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-4 col-md-offset-4">
            <div class="bs-example">
                <form>
                    <div class="form-group">
                        <label>Сколько цветов в радуге?</label>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="">
                                2
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="">
                                4
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="">
                                7
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Сколько дней в году?</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" >
                    </div>
                    <div class="form-group">
                        <label>Кто проживает на дне океана?</label>
                        <select class="form-control">
                            <option></option>
                            <option>Спанч боб</option>
                            <option>Медуза</option>
                            <option>Русалка</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary btn-lg btn-block" onclick="myFunction()">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="snackbar">Your answers sent</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    function myFunction() {
        var x = document.getElementById("snackbar")
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }
</script>
</html>