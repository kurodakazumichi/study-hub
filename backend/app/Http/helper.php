<?php
function response404($name) {
  return response()->json([
    'message' => $name . " not found."
  ], 404);
}

function response500($msg) {
  return response()->json([
    'message' => $msg
  ], 500);
}