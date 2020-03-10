Hola {{ $email->receptor }},

Contenido de tu correo:

-Nombre del proyecto:{{ $titulo }}.
-Curso:{{ $texto }}.

-Nombre:{{ $email->nombre }}.
-Comentario{{ $email->comentario }}.

Muchas gracias,
{{ $email->emisor }}
