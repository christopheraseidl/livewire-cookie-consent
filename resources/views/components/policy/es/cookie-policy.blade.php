<div id="cookie-policy">
    <livewire:cookie-consent-changer />

    <h1><strong>{{ config('app.name') }}</strong> informa acerca del uso de las cookies en su página web: <a href="{{ config('app.url') }}">{{ config('app.url') }}.</a></h1>

    <h2>¿Qué son las cookies?</h2>

    <p>Las cookies son archivos que se pueden descargar en su equipo a través de las páginas web. Son herramientas que tienen un papel esencial para la prestación de numerosos servicios de la sociedad de la información. Entre otros, permiten a una página web almacenar y recuperar información sobre los hábitos de navegación de un usuario o de su equipo y, dependiendo de la información obtenida, se pueden utilizar para reconocer al usuario y mejorar el servicio ofrecido.</p>

    <h2>Tipos de cookies</h2>

    <p>Según quien sea la entidad que gestione el dominio desde donde se envían las cookies y trate los datos que se obtengan se pueden distinguir dos tipos:</p>

    <ol>
        <li>Cookies propias: aquéllas que se envían al equipo terminal del usuario desde un equipo o dominio gestionado por el propio editor y desde el que se presta el servicio solicitado por el usuario.</li>
        <li>Cookies de terceros: aquéllas que se envían al equipo terminal del usuario desde un equipo o dominio que no es gestionado por el editor, sino por otra entidad que trata los datos obtenidos través de las cookies.</li>
    </ol>

    <p>En el caso de que las cookies sean instaladas desde un equipo o dominio gestionado por el propio editor pero la información que se recoja mediante éstas sea gestionada por un tercero, no pueden ser consideradas como cookies propias.</p>

    <p>Existe también una segunda clasificación según el plazo de tiempo que permanecen almacenadas en el navegador del cliente, pudiendo tratarse de:</p>

    <ol>
        <li>Cookies de sesión: diseñadas para recabar y almacenar datos mientras el usuario accede a una página web. Se suelen emplear para almacenar información que solo interesa conservar para la prestación del servicio solicitado por el usuario en una sola ocasión (p.e. una lista de productos adquiridos).</li>
        <li>Cookies persistentes: los datos siguen almacenados en el terminal y pueden ser accedidos y tratados durante un periodo definido por el responsable de la cookie, y que puede ir de unos minutos a varios años.</li>
    </ol>

    <p>Por último, existe otra clasificación según la finalidad para la que se traten los datos obtenidos:</p>

    <ol>
        <li>Cookies técnicas: aquellas que permiten al usuario la navegación a través de una página web, plataforma o aplicación y la utilización de las diferentes opciones o servicios que en ella existan como, por ejemplo, controlar el tráfico y la comunicación de datos, identificar la sesión, acceder a partes de acceso restringido, recordar los elementos que integran un pedido, realizar el proceso de compra de un pedido, realizar la solicitud de inscripción o participación en un evento, utilizar elementos de seguridad durante la navegación, almacenar contenidos para la difusión de vídeos o sonido o compartir contenidos a través de redes sociales.</li>
        <li>Cookies de personalización: permiten al usuario acceder al servicio con algunas características de carácter general predefinidas en función de una serie de criterios en el terminal del usuario como por ejemplo serian el idioma, el tipo de navegador a través del cual accede al servicio, la configuración regional desde donde accede al servicio, etc.</li>
        <li>Cookies de análisis: permiten al responsable de las mismas, el seguimiento y análisis del comportamiento de los usuarios de los sitios web a los que están vinculadas. La información recogida mediante este tipo de cookies se utiliza en la medición de la actividad de los sitios web, aplicación o plataforma y para la elaboración de perfiles de navegación de los usuarios de dichos sitios, aplicaciones y plataformas, con el fin de introducir mejoras en función del análisis de los datos de uso que hacen los usuarios del servicio.</li>
        <li>Cookies publicitarias: permiten la gestión, de la forma más eficaz posible, de los espacios publicitarios.</li>
        <li>Cookies de publicidad comportamental: almacenan información del comportamiento de los usuarios obtenida a través de la observación continuada de sus hábitos de navegación, lo que permite desarrollar un perfil específico para mostrar publicidad en función del mismo.</li>
        <li>Cookies de redes sociales externas: se utilizan para que los visitantes puedan interactuar con el contenido de diferentes plataformas sociales (facebook, youtube, twitter, linkedIn, etc.) y que se generen únicamente para los usuarios de dichas redes sociales. Las condiciones de utilización de estas cookies y la información recopilada se regula por la política de privacidad de la plataforma social correspondiente.</li>
    </ol>

    <h2>Desactivación y eliminación de cookies</h2>

    <p>Tienes la opción de permitir, bloquear o eliminar las cookies instaladas en tu equipo mediante la configuración de las opciones del navegador instalado en su equipo. Al desactivar cookies, algunos de los servicios disponibles podrían dejar de estar operativos. La forma de deshabilitar las cookies es diferente para cada navegador, pero normalmente puede hacerse desde el menú Herramientas u Opciones. También puede consultarse el menú de Ayuda del navegador dónde puedes encontrar instrucciones. El usuario podrá en cualquier momento elegir qué cookies quiere que funcionen en este sitio web.</p>

    <p>Puede usted permitir, bloquear o eliminar las cookies instaladas en su equipo mediante la configuración de las opciones del navegador instalado en su ordenador:</p>

    <ul>
        <li><a href="{{ __('cookie-consent::links.microsoft_cookie_link') }}" target="_blank">Microsoft Internet Explorer o Microsoft Edge</a></li>
        <li><a href="{{ __('cookie-consent::links.firefox_cookie_link') }}" target="_blank">Mozilla Firefox</a></li>
        <li><a href="{{ __('cookie-consent::links.chrome_cookie_link') }}" target="_blank">Chrome</a></li>
        <li><a href="{{ __('cookie-consent::links.safari_cookie_link') }}" target="_blank">Safari</a></li>
        <li><a href="{{ __('cookie-consent::links.opera_cookie_link') }}" target="_blank">Opera</a></li>
    </ul>

    <h2>Declaración de cookies utilizadas en <a href="{{ config('app.url') }}">{{ config('app.url') }}</a></h2>

    <p>Las cookies que utilizamos son las siguientes:</p>

    <ul>
        <li>"cas_laravel_cookie_consent," para detectar la aceptación o rechazo de la política de cookies, con una duración de o un año (en caso de respuesta positiva) o un mes (en caso de respuesta negativa).</li>
        <li>"XSRF - TOKEN," para proteger la página web contra ataques XSS.</li>
    </ul>

    <h2>Aceptación de la Política de cookies</h2>

    <p>{{ config('app.name') }} assumes that you accept the use of cookies. However, it displays information about its cookie policy at the bottom or top of any page of the portal with each login in order to make you aware of it.</p>

    <p>Ante esta información es posible llevar a cabo las siguientes acciones:</p>

    <ol>
        <li>Aceptar cookies. No se volverá a visualizar este aviso al acceder a cualquier página del portal durante la presente sesión.</li>
        <li>Cerrar. Se oculta el aviso en la presente página.</li>
        <li>Modify your settings. Al visitar la política de cookies de <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>, puede usted aceptar o rechazar el uso de las cookies.</li>
    </ol>
</div>