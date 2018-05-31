<?php

function valMsg($errors, $field)
{
    if ($errors->has($field)) {
        return "<span class='invalid-feedback'>
                    <strong> " . $errors->first($field) . " </strong>
                 </span>
               ";
    }
}

function getValClass($errors, $field)
{
    return $errors->has($field) ? "is-invalid" : "";
}

function checkbox($model = "")
{

    if ($model) {
        $checkbox = '<input class="checkbox" name="bulk" type="checkbox" value="' . $model->id . '">';
    } else {
        $checkbox = '<input id="checkAll" name="bulk" type="checkbox">';
    }

    return '
        <div class="pretty p-svg p-curve p-jelly p-bigger">
            ' . $checkbox . '
            <div class="state p-success">
                <!-- svg path -->
                <svg class="svg svg-icon" viewBox="0 0 20 20">
                    <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                </svg>
                <label></label>
            </div>
        </div>
    ';
}

function deleteForm($url)
{
    $form = Form::open(["method" => "Delete", "url" => $url]);
    $form .= Form::button("Delete <i class='far fa-trash-alt'></i>",
        ["class" => "btn btn-danger deleteButton", "type" => "submit", "data-toggle" => "modal", "data-target" => "#deleteModal"]);
    $form .= Form::close();

    return $form;
}

function checkRoute($testRoutes)
{
    $currentRoute = Route::currentRouteName();

    if (is_array($testRoutes)) {
        foreach ($testRoutes as $testRoute) {
            if ($currentRoute == $testRoute) {
                return "active";
            }
        }
    }

    return $currentRoute == $testRoutes ? "active" : "";
}