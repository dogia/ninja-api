<?php

function auth($id, $token, $model){
    $token = $model->where('cuenta_id', $id)->where('auth', $token)->first();
    return ($token !== false);
}