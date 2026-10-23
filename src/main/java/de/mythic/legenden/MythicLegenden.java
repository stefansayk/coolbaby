package de.mythic.legenden;

import net.fabricmc.api.ModInitializer;
import net.fabricmc.fabric.api.networking.v1.PayloadTypeRegistry;
import net.fabricmc.fabric.api.networking.v1.ServerPlayNetworking;
import net.minecraft.resources.Identifier;
import net.minecraft.server.MinecraftServer;
import net.minecraft.server.level.ServerPlayer;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * Mythic Legenden: six unique legendary weapons.
 * Recipes, abilities and the once-per-world rule live in the bundled data pack (data/mythic).
 * This class receives the ability key packet and runs the matching function for the player.
 */
public class MythicLegenden implements ModInitializer {
	public static final String MOD_ID = "mythic";
	public static final Logger LOGGER = LoggerFactory.getLogger(MOD_ID);

	@Override
	public void onInitialize() {
		PayloadTypeRegistry.serverboundPlay().register(AbilityPayload.TYPE, AbilityPayload.CODEC);
		ServerPlayNetworking.registerGlobalReceiver(AbilityPayload.TYPE, (payload, context) -> {
			ServerPlayer player = context.player();
			MinecraftServer server = context.server();
			server.execute(() -> castAbility(server, player));
		});
		LOGGER.info("Mythic Legenden geladen");
	}

	private static void castAbility(MinecraftServer server, ServerPlayer player) {
		if (player.isSpectator()) return;
		String cmd = "execute as " + player.getStringUUID() + " at @s run function mythic:key";
		server.getCommands().performPrefixedCommand(server.createCommandSourceStack().withSuppressedOutput(), cmd);
	}

	public static Identifier id(String path) {
		return Identifier.fromNamespaceAndPath(MOD_ID, path);
	}
}
