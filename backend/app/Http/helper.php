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
    'message' => $name . " not found.",
  ], Response::HTTP_NOT_FOUND);
}

function response422($errors) {
  return response()->json([
    'errors' => $errors,
  ], Response::HTTP_UNPROCESSABLE_ENTITY);
}

function response500($msg) {

  return response()->json([
    'errors'  => [$msg],
  ], Response::HTTP_INTERNAL_SERVER_ERROR);
}