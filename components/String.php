<?php
/**
 * 字符串处理工具类
 * @author isakura <isakura@yumisakura.cn>
 * @version v.01 开发
 */

namespace app\components;

class String
{

	/**
	 * 随机字符串生成方法
	 * integer $condition: generateRandomString( 30 ) | generateRandomString()
	 * string $condition: generateRandomString( '10-10-10' ) | generateRandomString( '10|10|10', '|' )
	 * array $condition: generateRandomString( [10,10,10] ) | generateRandomString( [10,10,10], '|' )
	 * @param  mixed $condition default:30
	 *         当 $condition 类型为整形时，表示随机字符串的长度
	 *         当 $condition 类型为字符串时，表示需要生成的随机字符串格式"[段长度][分隔符][段长度]..."
	 *         当 $condition 类型为数组时，表示生成带分隔符的随机字符串，每个数组值代表段长度(int)
	 *         注意：当 $condition 类型为数组时，请使用索引键
	 * @param  string  $separator 分隔符 default:'-'，当 $condition 为整形时不会被用到
	 *         支持的分隔符有：- | + * / 遇到不支持的分隔符将默认使用 -
	 * @return string             随机字符串
	 */
	public static function generateRandomString( $condition = 30, $separator = '-' )
	{
		if ( !in_array( $separator, ['-', '|', '+', '*', '/']) )
			$separator = '-';
		$randomString = '';
		$randomChar = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		$randomCharLength = strlen( $randomChar ) - 1;
		if ( is_integer( $condition ) )
		{
			for ( $i = 0; $i < $condition; $i++ )
				$randomString .= $randomChar[rand( 0, $randomCharLength )];
		}
		else if ( is_string( $condition ) )
		{
			// 传入的随机字符串格式中不存在对应的分隔符
			// 则返回长度为 30 的无分隔符随机字符串
			if ( !strpos( $condition, $separator ) )
			{
				for ( $i = 0; $i < 30; $i++ )
					$randomString .= $randomChar[rand( 0, $randomCharLength )];
			}
			else
			{
				$lengthArr = explode( $separator, $condition );
				foreach ( $lengthArr as $key => $len )
				{
					for ( $i = 0; $i < intval( $len ); $i++ )
						$randomString .= $randomChar[rand( 0, $randomCharLength )];
					if ( $key !== count( $lengthArr ) - 1 )
						$randomString .= $separator;
				}
			}
		}
		else if ( is_array( $condition ) )
		{
			foreach ( $condition as $key => $len )
			{
				for ( $i = 0; $i < intval( $len ); $i++ )
					$randomString .= $randomChar[rand( 0, $randomCharLength )];
				if ( $key !== count( $condition ) - 1 )
					$randomString .= $separator;
			}
		}
		return $randomString;
	}

	/**
	 * 生成验证码方法
	 * @param  integer $length 验证码长度
	 * @return integer          随机验证码
	 */
	public static function generateVerifyCode( $length = 4 )
	{
		$min = 0;
		$max = 9;
		if ( intval( $length ) === 1 )
			return rand( $min, $max );
		for ( $i = 1; $i < $length; $i++ )
		{
			if ( $i === 1 )
				$min = 10;
			else
				$min .= 0;
			$max .= 9;
		}
		return rand( intval( $min ), intval( $max ) );
	}

	/**
	 * 判断手机号格式是否正确
	 * @param  string  $mobile 手机号字符串
	 * @return boolean         TRUE | FALSE
	 */
	public static function isMobile( $mobile )
	{
		$result = preg_match( "/^1[34578]{1}[0-9]{9}$/", $mobile );
		return $result === 1 ? TRUE : FALSE;
	}
}