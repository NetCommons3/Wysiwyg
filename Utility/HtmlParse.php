<?php
/**
 * HtmlParse Utility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Ryohei Ohga <ohga.ryohei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('UserRole', 'UserRoles.Model');
App::uses('HTMLPurifier_Filter_Comment', 'Wysiwyg.Utility/Filter');

/**
 * Parse Utility
 *
 * @author Ryohei Ohga <ohga.ryohei@gmail.com>
 * @package NetCommons\Wysiwyg\Utility
 */
class HtmlParse {

	private $__config = array();

/**
 * コンストラクタ
 *
 * @return void
 */
	public function __construct() {
		$config = HTMLPurifier_Config::createDefault();
		$config->set('Attr.AllowedFrameTargets', array(
			'_blank',
			'_self',
			'_parent',
			'_top',
		));
		$config->set('Attr.AllowedRel', array(
			'alternate',
			'author',
			'bookmark',
			'help',
			'icon',
			'license',
			'next',
			'nofollow',
			'noreferrer',
			'prefetch',
			'prev',
			'search',
			'stylesheet',
			'tag',
		));
		$config->set('Attr.EnableID', true);
		$config->set('CSS.AllowImportant', true);
		$config->set('CSS.AllowTricky', true);
		$config->set('CSS.Proprietary', true);
		$config->set('Core.AllowHostnameUnderscore', true);
		$config->set('Core.ConvertDocumentToFragment', false);
		$config->set('Core.DisableExcludes', true);
		$config->set('Core.Encoding', 'UTF-8');
		$config->set('Core.MaintainLineNumbers', false);
		$config->set('HTML.Doctype', 'XHTML 1.0 Transitional');

		// Youtube関連
		$config->set('HTML.SafeIframe', true);
		$config->set('HTML.FlashAllowFullScreen', true);
		$config->set('HTML.Trusted', true);
		$config->set('URI.SafeIframeRegexp', '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/)%');
		$config->set('Output.FlashCompat', true);

		if (Current::read('RoomRolePermission.html_not_limited.value')) {
			// HTMLタグ使用権限がある場合
			$config->set('Core.HiddenElements', array());
			$config->set('HTML.Proprietary', true);
			$config->set('HTML.SafeEmbed', true);
			$config->set('URI.SafeIframeRegexp', '%^(https?:)?%');
		} else {
			$config->set('Filter.Custom', array(new HTMLPurifier_Filter_Comment()));
			$config->set('HTML.Allowed',
				'div,' .
				'span,' .
				'h1[align],' .
				'h2[align],' .
				'h3[align],' .
				'h4[align],' .
				'h5[align],' .
				'h6[align],' .
				'br[clear],' .
				'img[src|vspace|hspace|border|alt|height|width],' .
				'ol[compact|start|type],' .
				'ul[compact|type],' .
				'li[type|value],' .
				'a[href|target],' .
				'hr[align|color|noshade|size|width],' .
				'table[cellspacing|cellpadding|border|align],' .
				'tbody[align|bgcolor|char|charoff|valign],' .
				'tr[colspan|rowspan],' .
				'td[colspan|rowspan|bgcolor|align|valign|height|width|nowrap|char|charoff|abbr|axis|headers|scope],' .
				'blockquote[cite],' .
				'p[align],' .
				'th[colspan|rowspan|bgcolor|align|valign|height|width|nowrap|char|charoff|abbr|axis|headers|scope],' .
				'strong,' .
				'caption[align|valign],' .
				'cite,' .
				'code,' .
				'kbd,' .
				'pre[cols|width|wrap],' .
				'q,' .
				'rb,' .
				'ruby,' .
				'rp,' .
				'rt,' .
				'small,' .
				'sub,' .
				'sup,' .
				'wbr,' .
				'object[archive|border|classid|code|codebase|codetype|data|declare|name|standby|tabindex|type|usemap' .
					'|align|width|height|hspace|vspace],' .
				'embed[src|height|width|hspace|vspace|units|border|frameborder|play|loop|quality|pluginspage|type' .
					'|allowscriptaccess|allowfullscreen|flashvars],' .
				'noembed,' .
				'param[name|value],' .
				'em,' .
				'i,' .
				'iframe[src|height|width|hspace|vspace|marginheight|marginwidth|allowtransparency|frameborder' .
					'|border|bordercolor|allowfullscreen],' .
				'col[span],' .
				'colgroup[span],' .
				// HTML5で廃止--ここから
				'font[size|color|face],' .
				'big,' .
				'center,' .
				'tt,' .
				'u,' .
				's,' .
				'strike,' .
				// HTML5で廃止--ここまで
				// 全要素共通
				'*[class|id|title|cite|background|style|align|dir|lang|language]'
			);
			$config->set('CSS.AllowedProperties', array(
				'color'                   => true,
				'background-color'        => true,
				'margin'                  => true,
				'text-align'              => true,
				'margin-left'             => true,
				'margin-right'            => true,
				'margin-top'              => true,
				'margin-bottom'           => true,
				'padding'                 => true,
				'padding-left'            => true,
				'padding-right'           => true,
				'padding-top'             => true,
				'padding-bottom'          => true,
				'border'                  => true,
				'border-left'             => true,
				'border-right'            => true,
				'border-top'              => true,
				'border-bottom'           => true,
				'border-width'            => true,
				'border-left-width'       => true,
				'border-right-width'      => true,
				'border-top-width'        => true,
				'border-bottom-width'     => true,
				'border-style'            => true,
				'border-left-style'       => true,
				'border-right-style'      => true,
				'border-top-style'        => true,
				'border-bottom-style'     => true,
				'border-color'            => true,
				'border-left-color'       => true,
				'border-right-color'      => true,
				'border-top-color'        => true,
				'border-bottom-color'     => true,
				'display'                 => true,
				'position'                => true,
				'left'                    => true,
				'right'                   => true,
				'top'                     => true,
				'bottom'                  => true,
				'float'                   => true,
				'clear'                   => true,
				'z-index'                 => true,
				'direction'               => true,
				'unicode-bidi'            => true,
				'width'                   => true,
				'height'                  => true,
				'min-width'               => true,
				'min-height'              => true,
				'max-width'               => true,
				'max-height'              => true,
				'vertical-align'          => true,
				'overflow'                => true,
				'clip'                    => true,
				'visibility'              => true,
				'background'              => true,
				'background-image'        => true,
				'background-repeat'       => true,
				'background-attachment'   => true,
				'background-position'     => true,
				'font'                    => true,
				'font-style'              => true,
				'font-variant'            => true,
				'font-weight'             => true,
				'font-size'               => true,
				'line-height'             => true,
				'font-family'             => true,
				'text-indent'             => true,
				'text-justify'            => true,
				'text-decoration'         => true,
				'text-underline-position' => true,
				'text-shadow:'            => true,
				'letter-spacing'          => true,
				'text-transform'          => true,
				'white-space'             => true,
				'table-layout'            => true,
				'border-spacing'          => true,
				'empty-cells'             => true,
				'cursor'                  => true,
				'border-collapse'         => true,
			));
			$config->set('URI.AllowedSchemes', array(
				'http'   => true,
				'https'  => true,
				'mailto' => true,
				'ftp'    => true,
			));
		}

		$this->__config = $config;
	}

/**
 * パース処理
 *
 * @param $html
 * @return string
 */
	public function purify($html)
	{
		$purifier = new HTMLPurifier($this->__config);
		return $purifier->purify($html);
	}
}
