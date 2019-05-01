<?php

// ******************************** \\
// ***** CONTROLLER INTERFACE ***** \\
// ******************************** \\

namespace Pam\Controller;

/** ***********************************\
 * All controller classes specifications
 */
interface ControllerInterface
{
    /** ***********************\
     * Returns the url of a page
     * @param  string $page   => the name of the page
     * @param  array  $params => the url parameters
     * @return string         => the page url
     */
    public function url(string $page, array $params = []);

    /** *****************************************\
     * Redirects to a page with the function url()
     * @param string $page   => the name of the page
     * @param array  $params => the url parameters
     */
    public function redirect(string $page, array $params = []);

    /** ***************\
     * Renders the views
     * @param  string $view   => the view to render
     * @param  array  $params => (the parameters to render the view)
     * @return string         => the render of the view
     */
    public function render(string $view, array $params = []);

    /** *********************************\
     * Uploads a file to a specific folder
     * And returns the file name
     * @param  string $fileDir  => the folder(s) from the file folder
     * @return string $fileName => the file name
     */
    public function upload($fileDir);
}

