select date_trunc('day',tstamp) AS datetime , device as device, sum(tonnage) as avg_tonnage, 
max(kwh_sys) - min(kwh_sys) as sys_kwh, 
max(kwh_motor) - min(kwh_motor) as motor_kwh, 
(max(kwh_sys) - min(kwh_sys)) + (max(kwh_motor) - min(kwh_motor)) / sum(tonnage) as kwh_ton, 
avg(current) as avg_current from "hp_mill" where "device"::text LIKE '%PELLET%' 
and "tstamp"::text between '2020-08-25 14:00:00' and '2020-08-25 16:00:00'
group by "datetime", "device" 
order by "datetime" desc