scoreboard players add @s mythic.steps 1
execute if score @s mythic.steps matches 64.. run return run summon minecraft:marker ~ ~ ~ {Tags:["mythic.hit"]}
execute unless block ~ ~ ~ #mythic:passable run return run summon minecraft:marker ^ ^ ^-0.5 {Tags:["mythic.hit"]}
execute if entity @e[type=!#mythic:not_target,tag=!mythic.caster,distance=..1.2] run return run summon minecraft:marker ~ ~ ~ {Tags:["mythic.hit"]}
execute positioned ^ ^ ^0.5 run function mythic:util/ray_step
