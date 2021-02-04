SELECT max(kwh_sys) as maxsys,min(kwh_sys) as minsys,max(kwh_motor) as maxmotor, min(kwh_motor) as minmotor,
round(max(kwh_sys)-min(kwh_sys), 4) as kwhsys,
round(max(kwh_motor)- min(kwh_motor),4) as kwhmotor,
round((max(kwh_sys)-min(kwh_sys))+(max(kwh_motor)- min(kwh_motor)),4) AS kwhtot,
round(sum(tonnage),4) as tonna,
round(((max(kwh_sys)-min(kwh_sys)))+(max(kwh_motor)- min(kwh_motor))/sum(tonnage),4) as kwhton,
round(round(max(kwh_sys)-min(kwh_sys), 4)+round(max(kwh_motor)-min(kwh_motor))/round(sum(tonnage),4),4) as kwh_ton1
	FROM public.hp_mill
where "device"::text LIKE '%PELLET MILL 1%' and tonnage > 0 and kwh_sys>0 and kwh_motor>0 and "tstamp"::text 
between '2020-08-26 07:00:00' and '2020-08-26 07:59:05' 