<?php
require 'databaseconnect.php';
session_start();
if (isset ($_SESSION['Designation'])) {
  if ($_SESSION['Designation'] == 'student') {
    header("location:Student/dashboard_student.php");
  } elseif ($_SESSION['Designation'] == 'faculty') {
    header("location:Admin/includes/dashboard.php");
  }
}
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">

  <link rel="stylesheet" href="css/style.css">
  <title>Login | KDPIT Projects</title>
  <script nonce="9386abc8-d949-43f9-86cc-19a996ec09d3">try { (function (w, d) { !function (mo, mp, mq, mr) { mo[mq] = mo[mq] || {}; mo[mq].executed = []; mo.zaraz = { deferred: [], listeners: [] }; mo.zaraz.q = []; mo.zaraz._f = function (ms) { return async function () { var mt = Array.prototype.slice.call(arguments); mo.zaraz.q.push({ m: ms, a: mt }) } }; for (const mu of ["track", "set", "debug"]) mo.zaraz[mu] = mo.zaraz._f(mu); mo.zaraz.init = () => { var mv = mp.getElementsByTagName(mr)[0], mw = mp.createElement(mr), mx = mp.getElementsByTagName("title")[0]; mx && (mo[mq].t = mp.getElementsByTagName("title")[0].text); mo[mq].x = Math.random(); mo[mq].w = mo.screen.width; mo[mq].h = mo.screen.height; mo[mq].j = mo.innerHeight; mo[mq].e = mo.innerWidth; mo[mq].l = mo.location.href; mo[mq].r = mp.referrer; mo[mq].k = mo.screen.colorDepth; mo[mq].n = mp.characterSet; mo[mq].o = (new Date).getTimezoneOffset(); if (mo.dataLayer) for (const mB of Object.entries(Object.entries(dataLayer).reduce(((mC, mD) => ({ ...mC[1], ...mD[1] })), {}))) zaraz.set(mB[0], mB[1], { scope: "page" }); mo[mq].q = []; for (; mo.zaraz.q.length;) { const mE = mo.zaraz.q.shift(); mo[mq].q.push(mE) } mw.defer = !0; for (const mF of [localStorage, sessionStorage]) Object.keys(mF || {}).filter((mH => mH.startsWith("_zaraz_"))).forEach((mG => { try { mo[mq]["z_" + mG.slice(7)] = JSON.parse(mF.getItem(mG)) } catch { mo[mq]["z_" + mG.slice(7)] = mF.getItem(mG) } })); mw.referrerPolicy = "origin"; mw.src = "../../../cdn-cgi/zaraz/sd0d9.js?z=" + btoa(encodeURIComponent(JSON.stringify(mo[mq]))); mv.parentNode.insertBefore(mw, mv) };["complete", "interactive"].includes(mp.readyState) ? zaraz.init() : mo.addEventListener("DOMContentLoaded", zaraz.init) }(w, d, "zarazData", "script"); })(window, document) } catch (e) { throw fetch("/cdn-cgi/zaraz/t"), e; };
  </script>
  <style>
    .logo {
      width: 250px;
      height: auto;
      position: absolute;
      top: 20px;
      left: 20px;
    }

    .btn-primary {
      background-color: #005366;
      border-color: #005366;
    }

    .control--checkbox .control__indicator {
      background: #005366;
    }
  </style>
</head>


<body>
  <img src="images/KDPIT.webp" alt="KDPIT Logo" class="logo">

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('images/bg_1.jpg');"></div>
    <div class="contents order-2 order-md-1">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Login to <strong>KDPIT Projects</strong></h3>
            <p class="mb-4">All in one platform for seamless management of students projects, connecting facutlies and
              students effortlessly</p>
            <form action="Login.php" method="POST">
              <div class="form-group first">
                <label for="username">Username</label>
                <input type="text" class="form-control" placeholder="Enter your enrollment no." id="Username"
                  name="Username">
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" placeholder="Enter your password" id="Password"
                  name="Password" required>
              </div>
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked" />
                  <div class="control__indicator"></div>
                </label>
                <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span>
              </div>
              <button type="submit" name="sign_in" class="btn btn-block btn-primary"
                style="background-color: #005366; border-color: #005366;">Login</button>


            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317"
    integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA=="
    data-cf-beacon='{"rayId":"867bd78849f3a73e","b":1,"version":"2024.3.0","token":"cd0b4b3a733644fc843ef0b185f98241"}'
    crossorigin="anonymous"></script>
</body>

</html>