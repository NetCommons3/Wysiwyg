<?php
/**
 * HTMLPurifier_Filter_Comment Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryohei Ohga <ohga.ryohei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

class HTMLPurifier_Filter_Comment extends HTMLPurifier_Filter
{

/**
	 * @type string
	 */
	public $name = 'Comment';

	/**
     * コメントを除去
	 * @param string $html
	 * @param HTMLPurifier_Config $config
	 * @param HTMLPurifier_Context $context
	 * @return string
	 */
	public function postFilter($html, $config, $context)
	{
		return preg_replace('/<!-{2,}(.*?)-{2,}>/', '', $html);
	}
}

// vim: et sw=4 sts=4
