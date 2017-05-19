<?php
include "FaceDetector.php";
$face_detect = new Face_Detector('detection.dat');
$face_detect->face_detect('sample-image2.jpg');
$face_detect->toJpeg();
//print_r($face_detect->getFace());
?>