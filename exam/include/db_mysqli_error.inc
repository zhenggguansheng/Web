<?php
    //!function_exists('readover') && exit('Forbidden');
    Class DbError
    {
        function DbError($msg)
        {
            global $db_obstart, $db_host, $db_name, $db_charset;
            $tmp = $db_name->getCurrentDb();
            $sqlerror = mysqli_error($tmp->sql);
            $sqlerrno = mysqli_errno($tmp->sql);
            $sqlerror = str_replace($db_host,'dbhost',$sqlerror);
            ob_end_clean();
            $db_obstart && function_exists('ob_gzhandler') ? ob_start('ob_gzhandler') : ob_start();
            exit;
        }
    }
?>