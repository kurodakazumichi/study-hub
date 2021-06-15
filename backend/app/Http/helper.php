<?php

function response200($data = []) {
  return response()->json([
    'message' => 'ok',
    'data'    => $data
  ], 200);
}

function response201($name, $data) {
  return response()->json([
    'message' => $name . " created successfully.",
    'data'    => $data
  ], 201);
}

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