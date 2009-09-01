<?php
/**
 * The Horde_Mime_Viewer_Rfc822 class renders out messages from the
 * message/rfc822 content type.
 *
 * Copyright 2002-2009 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (GPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * @author  Michael Slusarz <slusarz@horde.org>
 * @package Horde_Mime_Viewer
 */
class Horde_Mime_Viewer_Rfc822 extends Horde_Mime_Viewer_Driver
{
    /**
     * Can this driver render various views?
     *
     * @var boolean
     */
    protected $_capability = array(
        'embedded' => false,
        'forceinline' => false,
        'full' => true,
        'info' => true,
        'inline' => false
    );

    /**
     * Return the full rendered version of the Horde_Mime_Part object.
     *
     * @return array  See Horde_Mime_Viewer_Driver::render().
     */
    protected function _render()
    {
        return array(
            $this->_mimepart->getMimeId() => array(
                'data' => $this->_mimepart->getContents(),
                'status' => array(),
                'type' => 'text/plain; charset=' . Horde_Nls::getCharset()
            )
        );
    }

    /**
     * Return the rendered information about the Horde_Mime_Part object.
     *
     * @return array  See Horde_Mime_Viewer_Driver::render().
     */
    protected function _renderInfo()
    {
        /* Get the text of the part.  Since we need to look for the end of
         * the headers by searching for the CRLFCRLF sequence, use
         * getCanonicalContents() to make sure we are getting the text with
         * CRLF's. */
        $text = $this->_mimepart->getContents(array('canonical' => true));
        if (empty($text)) {
            return array();
        }

        /* Search for the end of the header text (CRLFCRLF). */
        $text = substr($text, 0, strpos($text, "\r\n\r\n"));

        /* Get the list of headers now. */
        $headers = Horde_Mime_Headers::parseHeaders($text);

        $header_array = array(
            'date' => _("Date"),
            'from' => _("From"),
            'to' => _("To"),
            'cc' => _("Cc"),
            'bcc' => _("Bcc"),
            'reply-to' => _("Reply-To"),
            'subject' => _("Subject")
        );
        $header_output = array();

        foreach ($header_array as $key => $val) {
            $hdr = $headers->getValue($key);
            if (!empty($hdr)) {
                $header_output[] = '<strong>' . $val . ':</strong> ' . htmlspecialchars($hdr);
            }
        }

        return array(
            $this->_mimepart->getMimeId() => array(
                'data' => empty($header_output) ? '' : ('<div class="fixed mimeHeaders">' . Horde_Text_Filter::filter(implode("<br />\n", $header_output), 'emails') . '</div>'),
                'status' => array(),
                'type' => 'text/html; charset=' . Horde_Nls::getCharset()
            )
        );
    }
}
