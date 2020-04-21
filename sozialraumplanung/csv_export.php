<?php
								$list = array (
									array('', 'gesamte Bevölkerung', 'Summe', '0_u1', '1_u2', '2_u3', '3_u4', '4_u5', '5_u6', '6_u7', '7_u8', '8_u9', '9_u10'),
									array('2011', 'männlich', '$gesamt_m', '$gesamt_0_9_m', '$m[0]', '$m[1]', '$m[2]', '$m[3]', '$m[4]', '$m[5]', '$m[6]', '$m[7]', '$m[8]', '$m[9]')
								);

								$fp = fopen('test.csv', 'w');

								foreach ($list as $fields) {
									fputcsv($fp, $fields);
								}

								fclose($fp);
							?>