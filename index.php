<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Table Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-2">
    <div class="row">
        <div class="col-md-12">

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">DATE</th>
                    <th scope="col">DATA</th>
                    <th scope="col">HOST</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Zipcode</th>
                    <th scope="col">City</th>
                    <th scope="col">Country</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Latitude</th>
                    <th scope="col">Longitude</th>
                    
                </tr>
                </thead>
                <tbody>


                <?php include 'retrieve-data.php'; ?>
                <?php
                    if($result->num_rows > 0){
                        $n = 1;
                while($array=mysqli_fetch_row($result)){
                 ?>

                        <tr>
                            <th scope="row"><?php echo $array[0];?></th>
                            <td><?php echo $array[1];?></td>
                            <td><?php echo $array[2];?></td>
                            <td><?php echo $array[3];?></td>
                            <td><?php echo $array[4];?></td>
                            <td><?php echo $array[5];?></td>
                            <td><?php echo $array[6];?></td>
                            <td><?php echo $array[7];?></td>
                            <td><?php echo $array[8];?></td>
                            <td><?php echo $array[9];?></td>
                            <td><?php echo $array[10];?></td>
                            <td><?php echo $array[11];?></td>
                            <td><?php echo $array[12];?></td>
                        </tr>
                <?php
                }
                }else{?>
                    <tr>
                        <td colspan="3" rowspan="1" headers="">No Data Found</td>
                    </tr>
                    <?php } ?>

                <?php mysqli_free_result($result); ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
