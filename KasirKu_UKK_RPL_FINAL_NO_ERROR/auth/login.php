<?php
session_start(); require_once __DIR__.'/../config/database.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: ../index.php');exit;}
$email=trim($_POST['email']??''); $password=$_POST['password']??'';
if(!$email||!$password){header('Location: ../index.php?error=empty');exit;}
$s=$pdo->prepare("SELECT pengguna_id,nama_pengguna,email,password,peran FROM pengguna WHERE email=? LIMIT 1");
$s->execute([$email]); $u=$s->fetch();
if(!$u || !password_verify($password,$u['password'])){header('Location: ../index.php?error=invalid');exit;}
session_regenerate_id(true); $_SESSION['user']=['pengguna_id'=>$u['pengguna_id'],'nama_pengguna'=>$u['nama_pengguna'],'email'=>$u['email'],'peran'=>$u['peran']];
header('Location: ../dashboard/index.php'); exit;
