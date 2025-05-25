import { usePage } from "@inertiajs/react";
import { useRef, useState, useEffect } from "react";
import { Canvas, useFrame } from "@react-three/fiber";
import { OrbitControls } from "@react-three/drei";
import { useLoader } from "@react-three/fiber";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader";
import Layout from "../Components/Layouts/Layout";
import store from "@routes/store";

export default function ProductView() {
    const { product, model } = usePage().props;
    const gltf = model ? useLoader(GLTFLoader, model.original_url) : null;
    return (
        <Layout>
            <div className="h-screen flex flex-col px-16 py-8">
                <h2 className="text-2xl font-semibold mb-4">View Product</h2>
                <div className="flex gap-32 flex-1 items-center">
                    <div className="w-1/2 h-full p-8 border-2 border-black">
                        <Canvas>
                            <color attach="background" args={["#f5efe6"]} />
                            <ambientLight intensity={0.5} color="white" />
                            {model && <primitive object={gltf.scene} />}
                            <OrbitControls />
                        </Canvas>
                    </div>
                    <div className="w-1/2">
                        {!model && (
                            <p className="text-red-600 font-semibold text-xl">
                                No 3D model found for this product!
                            </p>
                        )}
                        <h1 className="text-2xl mt-4">{product.name}</h1>
                        <p>{product.description}</p>
                        <p className="mt-2">
                            P{product.price}/{product.unit}
                        </p>
                        <p className="mt-2">{product.stock_quantity} in stock</p>
                        <a
                            className="mt-16 px-4 py-2 hover:bg-teal-700 duration-200 bg-teal-600 inline-block rounded-lg"
                            href={store.index.get().url}
                        >
                            Back to Store
                        </a>
                    </div>
                </div>
            </div>
        </Layout>
    );
}
