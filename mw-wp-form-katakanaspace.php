<?php
/**
Plugin Name: MW WP Form KatakanaSpace
Plugin URI: http://chinotsubo.com
Description: 値がカタカナとスペース（オリジナル）
Version: 1.0.0
Author: Yuto Yamamoto
Author URI: http://chinotsubo.com
Created : 2015/03/27
Modified: 2015/03/27
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

 include dirname(__FILE__) . '/../mw-wp-form/system/mw_validation_rule.php';
 
class MW_Validation_Rule_Katakanaspace extends MW_Validation_Rule {

	/**
	 * バリデーションルール名を指定
	 */
	protected $name = 'katakanaspace';

	/**
	 * rule
	 * @param string $key name属性
	 * @param array $option
	 * @return string エラーメッセージ
	 */
	public function rule( $key, array $options = array() ) {
		$value = $this->Data->get( $key );
		if ( !is_null( $value ) && !MWF_Functions::is_empty( $value ) ) {
			if ( !preg_match( '/^[ァ-ヾ 　]*?[ァ-ヾ 　]+?[ァ-ヾ 　]*?$/u', $value ) ) {
				$defaults = array(
					'message' => __( 'Please enter with a Japanese Katakana.', MWF_Config::DOMAIN )
				);
				$options = array_merge( $defaults, $options );
				return $options['message'];
			}
		}
	}

	/**
	 * admin
	 * @param numeric $key バリデーションルールセットの識別番号
	 * @param array $value バリデーションルールセットの内容
	 */
	public function admin( $key, $value ) {
		?>
		<label><input type="checkbox" <?php checked( $value[$this->getName()], 1 ); ?> name="<?php echo MWF_Config::NAME; ?>[validation][<?php echo $key; ?>][<?php echo esc_attr( $this->getName() ); ?>]" value="1" />カタカナ(スペース有り)</label>
		<?php
	}
}

/**
 * my_validation_rule
 * @param array $validation_rules バリデーションルールオブジェクトの配列
 * @param string $key フォーム識別子
 */
function my_validation_rule( $validation_rules, $key ) {
    // 追加するバリデーションルールのオブジェクトは MW_Validation_Rule クラスを継承している必要があります。
    $validation_rules['katakanaspace'] = new MW_Validation_Rule_Katakanaspace( $key );
    return $validation_rules;
}
add_filter( 'mwform_validation_rules', 'my_validation_rule', 10, 2 );
