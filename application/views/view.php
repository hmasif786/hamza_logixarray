<!DOCTYPE html>
<html>
<head>
<title>FX Rates</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
            <form action="<?php echo base_url('index.php/Fxrates/currency_conversion');?>" name="" id="" method="post">
                <div class="form-group">
                    <select name="cars" id="cars">
                        <option value="AED">AED</option>
                        <option value="AUD">AUD</option>
                        <option value="CAD">CAD</option>
                        <option value="EUR">EUR</option>
                        <option value="SEK">SEK</option>
                        <option value="TRY">TRY</option>
                        <option value="USD">USD</option>
                    </select>
                    <input type="text" name="amount" class="form-control" id="text" placeholder="Please enter amount" required>
                </div> 
                <div class="form-group">
                <button type="submit" id="" class="btn btn-success">Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>