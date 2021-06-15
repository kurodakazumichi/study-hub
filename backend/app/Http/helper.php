<?php
use Illuminate\Http\Response;

function response200($data = []) {
  return response()->json([
    'message' => 'ok',
    'data'    => $data
  ], Response::HTTP_OK);
}

function response201($name, $data) {
  return response()->json([
    'message' => $name . " created successfully.",
    'data'    => $data
  ], Response::HTTP_CREATED);
}

function response404($name) {
  return response()->json([
    'message' => $name . " not found."
  ], Response::HTTP_NOT_FOUND);
}

function response500($msg, $data = []) {
  return response()->json([
    'message' => $msg,
    'data'    => $data,
  ], Response::HTTP_INTERNAL_SERVER_ERROR);
}