<?php
$db=new PDO('mysql:host=127.0.0.1;dbname=proyecto_asistencia','root','');
$res=$db->query("SELECT s.student_code, s.dni, s.semester, tc.name as career FROM students s LEFT JOIN technical_careers tc ON s.technical_career_id=tc.id WHERE s.student_code='TEST001'");
$row=$res->fetch(PDO::FETCH_ASSOC);
if($row){
    echo "Found: ".json_encode($row)."\n";
} else echo "Not found\n";
?>