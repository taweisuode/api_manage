<html>
<head>
<title><?php echo $result;?></title>
</head>
<body>
<?php echo $movie_list['movie_name'];?>
<?php if($max == 4){ ?>
aaa
<?php }else if( $max == 6){ ?>
asaas
<?php }else{ ?>
ccc
<?php }?>
<table>
{foreach name=$fruit}
<tr>
    <td><?php echo $key;?></td><td><?php echo $val;?></td>
</tr>
<?php } ?>
{foreach name=$test}
<tr>
    <td><?php echo $key;?></td><td><?php echo $val['yes'];?></td>
</tr>
<?php } ?>
</table>
</body>
</html>
