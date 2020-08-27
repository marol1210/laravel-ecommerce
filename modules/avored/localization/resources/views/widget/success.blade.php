<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>授权成功</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"></head>

	  <!-- Load required Bootstrap and BootstrapVue CSS -->
	<link type="text/css" rel="stylesheet" href="http://unpkg.com/bootstrap/dist/css/bootstrap.min.css" />
	<link type="text/css" rel="stylesheet" href="http://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css" />

	<!-- Load polyfills to support older browsers -->
	<script src="http://polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver" crossorigin="anonymous"></script>

	<!-- Load Vue followed by BootstrapVue -->
	<script src="http://unpkg.com/vue@latest/dist/vue.min.js"></script>
	<script src="http://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js"></script>

	<!-- Load the following for BootstrapVueIcons support -->
	<script src="http://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue-icons.min.js"></script>
  <body>
  	<div id="app">
  	    <b-container fluid>
	      <b-row>
	        <b-col></b-col>
	        <b-col cols=8>
	          <b-alert show variant="primary" style="text-align:center;margin-top:60%;">授权成功 <b-icon-check scale=2></b-icon-check></b-alert>
	        </b-col>
	        <b-col></b-col>
	      </b-row>
	    </b-container>
	</div>
    <script>
    	new Vue({
    		el:"#app"
    	});
    </script>
  </body>
</html>