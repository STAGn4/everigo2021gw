SELECT SQL_CALC_FOUND_ROWS
	b.data_type_2,
	b.send_type_1,
	b.source_type_1,
	b.source_code_1,
	b.to_type_1,
	b.to_code_1,
	b.c_stamp_1,
	b.record_type_1,
	b.cancell_type_1,
	b.category_code_1,
	b.trade_code_1,
	b.trade_code_branch_1,
	b.issuer_1,
	b.issuer_kana_1,
	b.publisher_2,
	b.publisher_kana_2,
	b.handling_company_1,
	b.handling_type_1,
	b.series_1,
	b.series_kana_1,
	b.series_volume_1,
	b.sub_series_1,
	b.sub_series_kana_1,
	b.sub_series_volume_1,
	b.total_volume_1,
	b.total_other_volume_1,
	b.distribution_count_1,
	b.name_1,
	b.kana_1,
	b.volume_2,
	b.sub_1,
	b.sub_kana_1,
	b.sub_volume_1,
	b.end_1,
	b.present_volume_1,
	b.author_1,
	b.author_kana_1,
	b.author_type_1,
	b.author_2,
	b.author_kana_2,
	b.author_type_2,
	b.author_3,
	b.author_kana_3,
	b.author_type_3,
	b.content_1,
	b.content_2,
	b.preliminary_5,
	b.book_size_2,
	b.book_size_3,
	b.page_1,
	b.bound_1,
	b.release_date_1,
	b.return_date_1,
	b.notation_price_1,
	b.price_1,
	b.price_tax_1,
	b.price_special_1,
	b.price_special_tax_1,
	b.price_special_policy_1,
	b.distribution_type_1,
	b.distribut_1,
	b.isbn_1,
	b.category_1,
	b.magazine_code_2,
	b.magazine_code_1,
	b.adult_1,
	b.pre_order_1,
	b.order_status_1,
	b.circulation_1,
	b.fix_1,
	b.typist_1,
	b.typist_tel_1,
	b.type_date_1,
	b.edit_time_stamp_1,
	b.win_info_1


from linkage_commissioner as b

WHERE b.book_no in ({$book_no_list|@join:','}) 
and b.status in(1,2)
and exists(
	select 1
	from book as n
	where n.publisher_no = {$publisher_no}
	and n.book_no = b.book_no
);
