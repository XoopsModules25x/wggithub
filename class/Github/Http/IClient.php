<?php

namespace XoopsModules\Wggithub\Github\Http;


/**
 * HTTP client interface.
 *
 * @author  Miloslav Hůla (https://github.com/milo)
 */
interface IClient
{
    /**
     * @param Request $request
     * @return Response
     */
    function request(Request $request);

    /**
     * @param  callable|NULL
     * @return self
     */
    function onRequest($callback);

    /**
     * @param  callable|NULL
     * @return self
     */
    function onResponse($callback);

}
