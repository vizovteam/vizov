<?php 
  $active_if_favorite = '';
  if (isset($favorites) && ( array_search($post->id, $favorites) !== false )) {
    $active_if_favorite = 'active';
    $favorite_tooltip_text = 'Удалить из избранных';
  } else {
    $favorite_tooltip_text = 'В избранные';
  }
?>
<span>
  <a href="#" class="favorite {{ $active_if_favorite }}" data-id="{{ $post->id }}" data-toggle="tooltip" data-placement="top" title="{{ $favorite_tooltip_text }}"><span class="glyphicon glyphicon-star"></span></a>
</span>