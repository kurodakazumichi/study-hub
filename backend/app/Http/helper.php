<?php
function response404($name) {
  return response()->json([
    'message' => $name . " not found."
  ], 404);
}