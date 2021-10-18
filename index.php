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
                            <th scope="row"><?php echo $n++; ?></th>
                            <td><?php echo $array[0];?></td>
                            <td><?php echo $array[1];?></td>
                        </tr>
                <?php 
            }
        }
                    <?php endwhile; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="3" rowspan="1" headers="">No Data Found</td>
                    </tr>
                <?php endif; ?>

                <?php mysqli_free_result($result); ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
