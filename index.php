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
                </tr>
                </thead>
                <tbody>
                <?php include 'retrieve-data.php'; ?>
                <?php
                while($array=mysqli_fetch_row($result)){
                ?>

                        <tr>
                            <th scope="row"><<?php echo $array[0];?></th>
                            <td><?php echo $array[1];?></td>
                            <td><?php echo $array[2];?></td>
                            <td><?php echo $array[3];?></td>
                        </tr>
               
               <?php
                
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
