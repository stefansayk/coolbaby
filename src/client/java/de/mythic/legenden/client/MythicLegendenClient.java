package de.mythic.legenden.client;

import com.mojang.blaze3d.platform.InputConstants;
import de.mythic.legenden.AbilityPayload;
import de.mythic.legenden.MythicLegenden;
import net.fabricmc.api.ClientModInitializer;
import net.fabricmc.fabric.api.client.event.lifecycle.v1.ClientTickEvents;
import net.fabricmc.fabric.api.client.keybinding.v1.KeyBindingHelper;
import net.fabricmc.fabric.api.client.networking.v1.ClientPlayNetworking;
import net.minecraft.client.KeyMapping;
import org.lwjgl.glfw.GLFW;

/** Registers the ability key (default X, changeable under Options > Controls). */
public class MythicLegendenClient implements ClientModInitializer {
	public static final KeyMapping.Category CATEGORY = KeyMapping.Category.register(MythicLegenden.id("legenden"));
	public static KeyMapping abilityKey;

	@Override
	public void onInitializeClient() {
		abilityKey = KeyBindingHelper.registerKeyBinding(
				new KeyMapping("key.mythic.ability", InputConstants.Type.KEYSYM, GLFW.GLFW_KEY_X, CATEGORY));
		ClientTickEvents.END_CLIENT_TICK.register(client -> {
			while (abilityKey.consumeClick()) {
				if (client.player != null && ClientPlayNetworking.canSend(AbilityPayload.TYPE)) {
					ClientPlayNetworking.send(AbilityPayload.INSTANCE);
				}
			}
		});
	}
}
